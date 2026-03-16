<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Member;
use App\Models\Plan;

class PaymentController extends Controller
{
    // Afficher historique des paiements
    public function index()
    {
        $payments = Payment::with('member', 'plan')->get();
        return view('payments.index', compact('payments'));
    }

    // Afficher form ajouter payment
    public function create()
    {
        $members = Member::all();
        $plans = Plan::all();
        return view('payments.create', compact('members', 'plans'));
    }

    // Enregistrer payment
   public function store(Request $request)
{
    $plan = Plan::find($request->plan_id);

    Payment::create([
        'member_id' => $request->member_id,
        'plan_id' => $request->plan_id,
        'amount' => $plan->price,
        'payment_date' => now(),
        'status' => 'payé'
    ]);

    return redirect()->route('payments.index')
    ->with('success','Payment ajouté');
}

    // Vérifier abonnement
    public function checkSubscription($member_id)
    {
        $payment = Payment::where('member_id', $member_id)
                          ->where('status', 'payé')
                          ->latest()
                          ->first();

        return $payment ? "Abonnement actif" : "Abonnement expiré";
    }
}