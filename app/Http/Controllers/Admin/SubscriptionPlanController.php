<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('sort_order')->get();
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_type' => 'required|in:monthly,quarterly,yearly',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'sort_order' => 'integer'
        ]);

        $validated['features'] = $request->features ?? [];
        
        SubscriptionPlan::create($validated);

        return redirect()->route('admin.plans.index')
                        ->with('success', 'Plan créé avec succès');
    }

    public function edit(SubscriptionPlan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, SubscriptionPlan $plan)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_type' => 'required|in:monthly,quarterly,yearly',
            'duration_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'features' => 'nullable|array',
            'is_active' => 'boolean',
            'sort_order' => 'integer'
        ]);

        $validated['features'] = $request->features ?? [];
        
        $plan->update($validated);

        return redirect()->route('admin.plans.index')
                        ->with('success', 'Plan mis à jour');
    }

    public function destroy(SubscriptionPlan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')
                        ->with('success', 'Plan supprimé');
    }

    public function toggleStatus(SubscriptionPlan $plan)
    {
        $plan->update(['is_active' => !$plan->is_active]);
        return redirect()->back()->with('success', 'Statut modifié');
    }
}