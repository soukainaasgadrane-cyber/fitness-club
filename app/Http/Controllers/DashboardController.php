<?php
namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        
        $totalWorkouts = 0; 
        $recentActivities = []; 
        
        return view('dashboard', compact('totalWorkouts', 'recentActivities'));
    }
}