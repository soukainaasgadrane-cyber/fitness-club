<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemberController extends Controller
{
    // Afficher la liste des membres avec recherche et pagination
    public function index(Request $request)
    {
        $query = Member::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $members = $query->with('subscriptions')->latest()->paginate(10);
        
        return view('admin.members.index', compact('members'));
    }

    // Afficher le formulaire pour créer un membre
    public function create()
    {
        return view('admin.members.create');
    }

    // Enregistrer un nouveau membre
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
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('members', 'public');
            $validated['photo'] = $path;
        }

        Member::create($validated);

        return redirect()->route('admin.members.index')
                        ->with('success', 'Le membre a été ajouté avec succès');
    }

    // Afficher les détails d’un membre
    public function show(Member $member)
    {
        $member->load('subscriptions');
        return view('admin.members.show', compact('member'));
    }

    // Afficher le formulaire pour modifier un membre
    public function edit(Member $member)
    {
        return view('admin.members.edit', compact('member'));
    }

    // Mettre à jour un membre
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
                        ->with('success', 'Les informations du membre ont été mises à jour avec succès');
    }

    // Supprimer un membre
    public function destroy(Member $member)
    {
        if ($member->photo) {
            Storage::disk('public')->delete($member->photo);
        }
        $member->delete();

        return redirect()->route('admin.members.index')
                        ->with('success', 'Le membre a été supprimé avec succès');
    }

    // Activer ou désactiver un membre
    public function toggleStatus(Member $member)
    {
        $member->update(['is_active' => !$member->is_active]);
        
        return redirect()->back()
                        ->with('success', 'Le statut du membre a été modifié avec succès');
    }
}