<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        
        $totalMembers = Member::count();
        $activeSubscriptions = Subscription::where('is_active', true)->count();
        $expiredSubscriptions = Subscription::where('end_date', '<', now())->count();
        $newMembersThisMonth = Member::whereMonth('created_at', now()->month)->count();
        
        
        $recentMembers = Member::with('subscriptions')
                              ->latest()
                              ->take(5)
                              ->get();
        
        
        $expiringSoon = Subscription::with('member')
                                   ->where('end_date', '>=', now())
                                   ->where('end_date', '<=', now()->addDays(7))
                                   ->where('is_active', true)
                                   ->get();
        
        return view('admin.dashboard', compact(
            'totalMembers',
            'activeSubscriptions',
            'expiredSubscriptions',
            'newMembersThisMonth',
            'recentMembers',
            'expiringSoon'
        ));
    }
}