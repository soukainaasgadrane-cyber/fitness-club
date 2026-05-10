<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::with(['member', 'plan'])->latest()->paginate(15);

        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::active()->count();
        $totalRevenue = Subscription::where('payment_status', 'paid')->sum('total_amount');
        $monthRevenue = Subscription::where('payment_status', 'paid')
            ->whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('total_amount');
        $pendingPayments = Subscription::where('payment_status', 'pending')->count();
        $expiredSubscriptions = Subscription::expired()->count();

        return view('admin.subscriptions.index', compact(
            'subscriptions',
            'totalSubscriptions',
            'activeSubscriptions',
            'totalRevenue',
            'monthRevenue',
            'pendingPayments',
            'expiredSubscriptions'
        ));
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
            'end_date' => 'required|date|after:start_date',
            'price' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer',
            'notes' => 'nullable|string'
        ]);

        $plan = SubscriptionPlan::findOrFail($validated['plan_id']);
        
        Subscription::create([
            'member_id' => $validated['member_id'],
            'plan_id' => $plan->id,
            'plan_type' => $plan->duration_type,
            'price' => $validated['price'],
            'total_amount' => $validated['price'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'payment_due_date' => $validated['start_date'],
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
            'notes' => $validated['notes'] ?? null,
            'is_active' => true
        ]);

        return redirect()->route('admin.subscriptions.index')
                        ->with('success', 'Abonnement créé avec succès');
    }

    public function show(Subscription $subscription)
    {
        $subscription->load(['member', 'plan']);

        return view('admin.subscriptions.show', compact('subscription'));
    }
}