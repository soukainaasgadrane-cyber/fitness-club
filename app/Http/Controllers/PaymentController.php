<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentController extends Controller
{
    // Afficher tous les paiements
    public function index()
    {
        $payments = Payment::with('member', 'plan')->get();
        return view('payments.index', compact('payments'));
    }

    // Afficher formulaire de création de paiement
    public function create()
    {
        $members = Member::all();
        $plans = Plan::all();
        return view('payments.create', compact('members', 'plans'));
    }

    // Stocker un nouveau paiement
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'plan_id' => 'required|exists:plans,id',
            'status' => 'required|string',
        ]);

        // Vérifier que le plan existe
        $plan = Plan::find($request->plan_id);
        if (!$plan) {
            return back()->with('error', 'Plan introuvable');
        }

        // Créer le paiement
        Payment::create([
            'member_id' => $request->member_id,
            'plan_id' => $request->plan_id,
            'amount' => $plan->price,
            'payment_date' => now(),
            'status' => $request->status,
        ]);

        return redirect()->route('payments.index')
                         ->with('success', 'Paiement ajouté avec succès');
    }

    // Vérifier l’abonnement d’un membre
    public function checkSubscription($member_id)
    {
        $payment = Payment::where('member_id', $member_id)
                          ->where('status', 'payé')
                          ->latest()
                          ->first();

        if (!$payment) {
            return "Aucun abonnement";
        }

        $plan = $payment->plan;

        $endDate = Carbon::parse($payment->payment_date)
                        ->addDays($plan->duration);

        if (now()->lessThanOrEqualTo($endDate)) {
            return "Abonnement actif";
        }

        return "Abonnement expiré";
    }
}