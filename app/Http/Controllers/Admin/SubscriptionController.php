<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['member', 'plan'])
                                    ->latest()
                                    ->paginate(15);
        
        $stats = [
            'active' => Subscription::active()->count(),
            'expired' => Subscription::expired()->count(),
            'overdue' => Subscription::overdue()->count(),
            'total_revenue' => Subscription::where('payment_status', 'paid')->sum('total_amount')
        ];
        
        return view('admin.subscriptions.index', compact('subscriptions', 'stats'));
    }

    public function create()
    {
        $members = Member::where('is_active', true)->get();
        $plans = SubscriptionPlan::where('is_active', true)->get();
        
        return view('admin.subscriptions.create', compact('members', 'plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:subscription_plans,id',
            'start_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'notes' => 'nullable|string'
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        
        // Calculer le prix total
        $basePrice = $plan->discount_price ?? $plan->price;
        $discount = $request->discount ?? 0;
        $totalAmount = $basePrice - $discount;
        
        // Calculer la date de fin
        $endDate = date('Y-m-d', strtotime($request->start_date . " + {$plan->duration_months} months"));
        
        // Générer le numéro de facture
        $invoiceNumber = 'INV-' . date('Ymd') . '-' . Str::random(6);
        
        $subscription = Subscription::create([
            'member_id' => $request->member_id,
            'plan_id' => $plan->id,
            'plan_type' => $plan->duration_type,
            'price' => $basePrice,
            'discount' => $discount,
            'total_amount' => $totalAmount,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'payment_due_date' => $request->start_date,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'invoice_number' => $invoiceNumber,
            'notes' => $request->notes,
            'is_active' => true
        ]);

        // Enregistrer l'historique
        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id(),
            'action' => 'created',
            'new_data' => $subscription->toArray(),
            'notes' => 'Abonnement créé'
        ]);

        return redirect()->route('admin.subscriptions.index')
                        ->with('success', 'Abonnement créé avec succès');
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['member', 'plan', 'payments', 'histories.user']);
        return view('admin.subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $members = Member::where('is_active', true)->get();
        $plans = SubscriptionPlan::where('is_active', true)->get();
        
        return view('admin.subscriptions.edit', compact('subscription', 'members', 'plans'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $validated = $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'end_date' => 'required|date',
            'discount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string'
        ]);

        $oldData = $subscription->toArray();
        
        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $basePrice = $plan->discount_price ?? $plan->price;
        $discount = $request->discount ?? 0;
        $totalAmount = $basePrice - $discount;
        
        $subscription->update([
            'plan_id' => $plan->id,
            'plan_type' => $plan->duration_type,
            'price' => $basePrice,
            'discount' => $discount,
            'total_amount' => $totalAmount,
            'end_date' => $request->end_date,
            'notes' => $request->notes
        ]);

        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id(),
            'action' => 'updated',
            'old_data' => $oldData,
            'new_data' => $subscription->toArray(),
            'notes' => 'Abonnement modifié'
        ]);

        return redirect()->route('admin.subscriptions.show', $subscription)
                        ->with('success', 'Abonnement mis à jour');
    }

    public function renew(Subscription $subscription, Request $request)
    {
        $request->validate([
            'new_end_date' => 'required|date|after:' . $subscription->end_date,
            'payment_method' => 'required|in:cash,card,bank_transfer,check'
        ]);

        $oldEndDate = $subscription->end_date;
        
        // Générer nouvelle facture
        $newInvoiceNumber = 'INV-' . date('Ymd') . '-' . Str::random(6);
        
        // Créer le paiement
        $payment = \App\Models\Payment::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => $newInvoiceNumber,
            'amount' => $subscription->total_amount,
            'total_paid' => $subscription->total_amount,
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
            'status' => 'completed',
            'notes' => 'Renouvellement d\'abonnement'
        ]);
        
        // Mettre à jour l'abonnement
        $subscription->update([
            'end_date' => $request->new_end_date,
            'payment_status' => 'paid',
            'payment_date' => now(),
            'is_active' => true
        ]);
        
        // Historique
        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id(),
            'action' => 'renewed',
            'old_data' => ['end_date' => $oldEndDate],
            'new_data' => ['end_date' => $request->new_end_date],
            'notes' => 'Abonnement renouvelé'
        ]);

        return redirect()->route('admin.subscriptions.show', $subscription)
                        ->with('success', 'Abonnement renouvelé avec succès');
    }

    public function markAsPaid(Subscription $subscription, Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'amount_received' => 'required|numeric|min:0'
        ]);

        $subscription->update([
            'payment_status' => 'paid',
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method,
            'is_active' => true
        ]);

        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id(),
            'action' => 'payment_received',
            'new_data' => ['payment_status' => 'paid', 'payment_date' => $request->payment_date],
            'notes' => 'Paiement reçu: ' . $request->amount_received . ' DH'
        ]);

        return redirect()->back()->with('success', 'Paiement enregistré');
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'is_active' => false,
            'payment_status' => 'overdue'
        ]);

        SubscriptionHistory::create([
            'subscription_id' => $subscription->id,
            'user_id' => Auth::id(),
            'action' => 'cancelled',
            'notes' => 'Abonnement annulé'
        ]);

        return redirect()->route('admin.subscriptions.index')
                        ->with('success', 'Abonnement annulé');
    }
}