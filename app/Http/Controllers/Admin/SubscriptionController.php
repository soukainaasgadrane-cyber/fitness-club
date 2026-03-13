<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionController extends Controller
{
    /**
     * Affiche la liste des abonnements avec filtres
     */
    public function index(Request $request)
    {
        // Construction de la requête de base avec les relations
        $query = Subscription::with(['member', 'plan']);

        // ===== FILTRES =====
        
        // Filtre par statut (actif, expiré, en attente)
        if ($request->has('status')) {
            switch($request->status) {
                case 'active':  // Abonnements actifs
                    $query->where('is_active', true)
                          ->where('end_date', '>=', now());
                    break;
                case 'expired':  // Abonnements expirés
                    $query->where('end_date', '<', now());
                    break;
                case 'pending':  // Paiements en attente
                    $query->where('payment_status', 'pending');
                    break;
            }
        }

        // Filtre par type d'abonnement (mensuel, trimestriel, annuel)
        if ($request->has('plan_type') && $request->plan_type != 'all') {
            $query->whereHas('plan', function($q) use ($request) {
                $q->where('duration_type', $request->plan_type);
            });
        }

        // Récupération des résultats avec pagination (10 par page)
        $subscriptions = $query->latest()->paginate(10);
        
        // ===== STATISTIQUES POUR LE DASHBOARD =====
        $stats = [
            // Nombre d'abonnements actifs
            'active' => Subscription::where('is_active', true)
                                   ->where('end_date', '>=', now())
                                   ->count(),
            
            // Nombre d'abonnements expirés
            'expired' => Subscription::where('end_date', '<', now())->count(),
            
            // Revenu total (somme de tous les paiements complétés)
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            
            // Paiements en attente
            'pending_payments' => Subscription::where('payment_status', 'pending')->count()
        ];

        // Envoi des données à la vue
        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    /**
     * Affiche le formulaire de création d'un nouvel abonnement
     */
    public function create()
    {
        // Récupère tous les membres actifs
        $members = Member::where('is_active', true)->get();
        
        // Récupère tous les plans d'abonnement actifs
        $plans = SubscriptionPlan::where('is_active', true)->get();
        
        return view('admin.subscriptions.create', compact('members', 'plans'));
    }

    /**
     * Enregistre un nouvel abonnement dans la base de données
     */
    public function store(Request $request)
    {
        // ===== VALIDATION DES DONNÉES =====
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',           // Le membre doit exister
            'plan_id' => 'required|exists:subscription_plans,id', // Le plan doit exister
            'start_date' => 'required|date',                       // Date de début valide
            'payment_method' => 'required|in:cash,card,bank_transfer', // Méthode de paiement autorisée
            'amount_paid' => 'required|numeric|min:0',            // Montant payé (peut être 0)
            'notes' => 'nullable|string'                           // Notes optionnelles
        ]);

        // ===== TRANSACTION =====
        // Utilisation d'une transaction pour garantir l'intégrité des données
        DB::beginTransaction();
        try {
            // Récupération du plan choisi
            $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
            
            // Calcul des dates
            $startDate = \Carbon\Carbon::parse($validated['start_date']);
            $endDate = $startDate->copy()->addMonths($plan->duration_months);

            // ===== CRÉATION DE L'ABONNEMENT =====
            $subscription = Subscription::create([
                'member_id' => $validated['member_id'],
                'plan_id' => $plan->id,
                'plan_type' => $plan->duration_type,               // Type de durée
                'price' => $plan->price,                            // Prix total
                'start_date' => $validated['start_date'],
                'end_date' => $endDate,
                'amount_paid' => $validated['amount_paid'],        // Montant déjà payé
                'remaining_amount' => $plan->price - $validated['amount_paid'], // Reste à payer
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['amount_paid'] >= $plan->price ? 'paid' : 'partial',
                'notes' => $validated['notes'],
                'is_active' => true
            ]);

            // ===== ENREGISTREMENT DU PREMIER PAIEMENT =====
            if ($validated['amount_paid'] > 0) {
                $subscription->recordPayment(
                    $validated['amount_paid'],
                    $validated['payment_method'],
                    auth()->id(),                                   // ID de l'utilisateur connecté
                    'Premier paiement pour l\'abonnement'
                );
            }

            // Validation de la transaction
            DB::commit();

            return redirect()->route('admin.subscriptions.index')
                           ->with('success', 'Abonnement créé avec succès');

        } catch (\Exception $e) {
            // En cas d'erreur, annulation de la transaction
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Affiche les détails d'un abonnement spécifique
     */
    public function show(Subscription $subscription)
    {
        // Charge les relations nécessaires
        $subscription->load([
            'member', 
            'plan', 
            'payments' => function($q) {
                $q->latest();  // Paiements du plus récent au plus ancien
            }
        ]);

        return view('admin.subscriptions.show', compact('subscription'));
    }

    /**
     * Renouvelle un abonnement existant
     */
    public function renew(Request $request, Subscription $subscription)
    {
        // Validation des données
        $validated = $request->validate([
            'new_start_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer'
        ]);

        DB::beginTransaction();
        try {
            // Désactivation de l'ancien abonnement
            $subscription->update(['is_active' => false]);

            // Création du nouvel abonnement (méthode à définir dans le modèle Subscription)
            $newSubscription = $subscription->renew(
                $validated['new_start_date'],
                $validated['payment_method'],
                auth()->id()
            );

            DB::commit();

            return redirect()->route('admin.subscriptions.show', $newSubscription)
                           ->with('success', 'Abonnement renouvelé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Ajoute un paiement à un abonnement existant
     */
    public function addPayment(Request $request, Subscription $subscription)
    {
        // Validation : le montant ne doit pas dépasser le reste à payer
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $subscription->remaining_amount,
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'notes' => 'nullable|string'
        ]);

        try {
            // Enregistrement du paiement via la méthode du modèle
            $payment = $subscription->recordPayment(
                $validated['amount'],
                $validated['payment_method'],
                auth()->id(),
                $validated['notes']
            );

            return redirect()->route('admin.subscriptions.show', $subscription)
                           ->with('success', 'Paiement enregistré avec succès');

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }
}