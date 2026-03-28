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
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'notes' => 'nullable|string'
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        
        $subscription = Subscription::create([
            'member_id' => $request->member_id,
            'plan_id' => $plan->id,
            'plan_type' => $plan->duration_type,
            'price' => $request->price,
            'total_amount' => $request->price,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'payment_due_date' => $request->start_date,
            'payment_status' => 'pending',
            'payment_method' => $request->payment_method,
            'notes' => $request->notes,
            'is_active' => true
        ]);

        return redirect()->route('admin.subscriptions.index')
                        ->with('success', 'Abonnement créé avec succès');
    }
}