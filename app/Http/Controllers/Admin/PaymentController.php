<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Affiche la liste des paiements avec filtres
     */
    public function index(Request $request)
    {
        // Construction de la requête de base avec les relations
        $query = Payment::with(['member', 'subscription', 'user']);

        // ===== SYSTÈME DE FILTRES AVANCÉ =====
        
        // Filtre par date de début
        if ($request->has('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        
        // Filtre par date de fin
        if ($request->has('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        // Filtre par méthode de paiement (espèces, carte, virement)
        if ($request->has('method') && $request->method != 'all') {
            $query->where('payment_method', $request->method);
        }

        // Filtre par statut (complété, en attente, remboursé)
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // ===== RECHERCHE =====
        // Recherche par numéro de facture ou nom du membre
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('payment_number', 'like', "%{$search}%")
                  ->orWhereHas('member', function($memberQuery) use ($search) {
                      $memberQuery->where('first_name', 'like', "%{$search}%")
                                  ->orWhere('last_name', 'like', "%{$search}%");
                  });
            });
        }

        // Récupération des résultats avec pagination (15 par page)
        $payments = $query->latest('payment_date')->paginate(15);

        // ===== STATISTIQUES POUR LE DASHBOARD =====
        $stats = [
            // Total des paiements aujourd'hui
            'total_today' => Payment::whereDate('payment_date', today())
                                   ->where('status', 'completed')
                                   ->sum('amount'),
            
            // Total des paiements ce mois
            'total_month' => Payment::whereMonth('payment_date', now()->month)
                                   ->whereYear('payment_date', now()->year)
                                   ->where('status', 'completed')
                                   ->sum('amount'),
            
            // Total des paiements cette année
            'total_year' => Payment::whereYear('payment_date', now()->year)
                                  ->where('status', 'completed')
                                  ->sum('amount'),
            
            // Nombre de paiements aujourd'hui
            'count_today' => Payment::whereDate('payment_date', today())
                                   ->where('status', 'completed')
                                   ->count()
        ];

        return view('admin.payments.index', compact('payments', 'stats'));
    }

    /**
     * Affiche les détails d'un paiement spécifique
     */
    public function show(Payment $payment)
    {
        // Charge toutes les relations nécessaires
        $payment->load([
            'member', 
            'subscription.plan',  // Plan de l'abonnement associé
            'user'                 // Utilisateur qui a enregistré le paiement
        ]);
        
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Rembourse un paiement (annulation)
     */
    public function refund(Request $request, Payment $payment)
    {
        // Validation de la raison du remboursement
        $request->validate([
            'reason' => 'required|string'  // Motif du remboursement obligatoire
        ]);

        // Vérification si déjà remboursé
        if ($payment->status === 'refunded') {
            return back()->with('error', 'Ce paiement est déjà remboursé');
        }

        // ===== TRANSACTION DE REMBOURSEMENT =====
        DB::beginTransaction();
        try {
            // 1. Mise à jour du statut du paiement
            $payment->update([
                'status' => 'refunded',
                'notes' => $payment->notes . "\nRemboursé : " . $request->reason
            ]);

            // 2. Mise à jour de l'abonnement associé
            $subscription = $payment->subscription;
            $subscription->amount_paid -= $payment->amount;        // Réduction du montant payé
            $subscription->remaining_amount += $payment->amount;    // Augmentation du reste à payer
            
            // 3. Mise à jour du statut de paiement de l'abonnement
            if ($subscription->amount_paid <= 0) {
                $subscription->payment_status = 'pending';  // Plus rien payé
            } else {
                $subscription->payment_status = 'partial';   // Paiement partiel
            }
            
            $subscription->save();

            DB::commit();

            return back()->with('success', 'Paiement remboursé avec succès');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur : ' . $e->getMessage());
        }
    }

    /**
     * Exporte les paiements vers un fichier CSV
     */
    public function export(Request $request)
    {
        // Construction de la requête avec les filtres
        $query = Payment::with(['member', 'subscription']);

        // Application des filtres de date si fournis
        if ($request->has('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        if ($request->has('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        // Récupération des paiements complétés uniquement
        $payments = $query->where('status', 'completed')
                         ->orderBy('payment_date')
                         ->get();

        // ===== GÉNÉRATION DU FICHIER CSV =====
        $filename = 'paiements_' . now()->format('Y-m-d_His') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // En-têtes du fichier CSV
        fputcsv($handle, [
            'Numéro facture',
            'Membre',
            'Date',
            'Montant (MAD)',
            'Méthode paiement',
            "Type d'abonnement",
            'Notes'
        ]);

        // Données des paiements
        foreach ($payments as $payment) {
            fputcsv($handle, [
                $payment->payment_number,
                $payment->member->full_name,
                $payment->payment_date->format('Y-m-d'),
                number_format($payment->amount, 2),  // Formatage du montant
                $this->getPaymentMethodFrench($payment->payment_method),
                $payment->subscription->plan->name ?? '-',
                $payment->notes
            ]);
        }

        // Préparation du fichier pour téléchargement
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return response($content)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Méthode utilitaire pour traduire les méthodes de paiement
     */
    private function getPaymentMethodFrench($method)
    {
        return match($method) {
            'cash' => 'Espèces',
            'card' => 'Carte bancaire',
            'bank_transfer' => 'Virement',
            'check' => 'Chèque',
            default => $method
        };
    }
}