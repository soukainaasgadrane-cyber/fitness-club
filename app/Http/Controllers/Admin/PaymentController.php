<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Member;
use App\Models\Plan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('member','plan')->get();

        $totalReceived = Payment::where('status','payé')->sum('amount');

        return view('payments.index', compact('payments','totalReceived'));
    }

    public function create()
    {
        $members = Member::all();
        $plans = Plan::all();

        return view('payments.create', compact('members','plans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'plan_id' => 'required',
            'status' => 'required'
        ]);

        $plan = Plan::find($request->plan_id);

        Payment::create([
            'member_id' => $request->member_id,
            'plan_id' => $request->plan_id,
            'amount' => $plan->price,
            'payment_date' => now(),
            'status' => $request->status
        ]);

        return redirect()->route('payments.index')
            ->with('success','Payment ajouté');
    }
}