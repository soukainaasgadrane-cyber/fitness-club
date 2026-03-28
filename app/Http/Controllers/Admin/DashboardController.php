<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Subscription;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // ========== STATISTIQUES SOUKAINA ==========
        $totalMembers = Member::count();
<<<<<<< HEAD
        $activeMembers = Member::where('is_active', true)->count();
=======
        $activeSubscriptions = Subscription::where('is_active', true)->count();
        $expiredSubscriptions = Subscription::where('end_date', '<', now())->count();
>>>>>>> 48904531f7e5389443fa82bf8bbe0e8645c19fec
        $newMembersThisMonth = Member::whereMonth('created_at', now()->month)->count();
        
        // Derniers membres inscrits
        $recentMembers = Member::latest()->take(5)->get();
        
        // ========== STATISTIQUES GHITA ==========
        // Abonnements
        $totalSubscriptions = Subscription::count();
        $activeSubscriptions = Subscription::where('is_active', true)
                                            ->where('end_date', '>=', now())
                                            ->count();
        $expiredSubscriptions = Subscription::where('end_date', '<', now())->count();
        $pendingSubscriptions = Subscription::where('payment_status', 'pending')->count();
        
        // Paiements
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $todayRevenue = Payment::whereDate('payment_date', today())
                               ->where('status', 'completed')
                               ->sum('amount');
        $monthRevenue = Payment::whereMonth('payment_date', now()->month)
                               ->where('status', 'completed')
                               ->sum('amount');
        
        $recentPayments = Payment::with(['subscription.member'])
                                 ->latest()
                                 ->take(5)
                                 ->get();
        
<<<<<<< HEAD
        // Abonnements qui expirent bientôt (7 jours)
        $expiringSoon = Subscription::with(['member', 'plan'])
                                    ->where('is_active', true)
                                    ->where('end_date', '>=', now())
                                    ->where('end_date', '<=', now()->addDays(7))
                                    ->get();
        
        return view('admin.dashboard', compact(
            'totalMembers', 'activeMembers', 'newMembersThisMonth', 'recentMembers',
            'totalSubscriptions', 'activeSubscriptions', 'expiredSubscriptions', 
            'pendingSubscriptions', 'totalRevenue', 'todayRevenue', 'monthRevenue',
            'recentPayments', 'expiringSoon'
=======
        return view('admin.dashboard', compact(
            'totalMembers',
            'activeSubscriptions',
            'expiredSubscriptions',
            'newMembersThisMonth',
            'recentMembers',
            'expiringSoon'
>>>>>>> 48904531f7e5389443fa82bf8bbe0e8645c19fec
        ));
    }
}