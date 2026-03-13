<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Member::query();
        
        // بحث
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        
        if ($request->has('status') && $request->status != 'all') {
            if ($request->status == 'active') {
                $query->whereHas('subscriptions', function($q) {
                    $q->where('is_active', true)
                      ->where('end_date', '>=', now());
                });
            } elseif ($request->status == 'inactive') {
                $query->whereDoesntHave('subscriptions', function($q) {
                    $q->where('is_active', true)
                      ->where('end_date', '>=', now());
                });
            }
        }
        
        $members = $query->with('subscriptions')
                        ->latest()
                        ->paginate(10);
        
        return view('admin.members.index', compact('members'));
    }

    
    public function create()
    {
        return view('admin.members.create');
    }

    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        $member = Member::create($validated);

        return redirect()->route('admin.members.index')
                        ->with('success', 'تم إضافة العضو بنجاح');
    }

    
    public function show(Member $member)
    {
        $member->load('subscriptions');
        
        
        $totalSubscriptions = $member->subscriptions()->count();
        $activeSubscription = $member->activeSubscription;
        $totalPaid = $member->subscriptions()->sum('price');
        
        return view('admin.members.show', compact('member', 'totalSubscriptions', 'activeSubscription', 'totalPaid'));
    }

    
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    
    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email,' . $member->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);

        
        if ($request->hasFile('photo')) {
            
            if ($member->photo) {
                Storage::disk('public')->delete($member->photo);
            }
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        $member->update($validated);

        return redirect()->route('admin.members.index')
                        ->with('success', 'تم تحديث بيانات العضو بنجاح');
    }

    
    public function destroy(Member $member)
    {
        
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        
        
        $member->delete();

        return redirect()->route('admin.members.index')
                        ->with('success', 'تم حذف العضو بنجاح');
    }

    
    public function toggleStatus(Member $member)
    {
        $member->update(['is_active' => !$member->is_active]);
        
        return redirect()->back()
                        ->with('success', 'تم تغيير حالة العضو بنجاح');
    }
}