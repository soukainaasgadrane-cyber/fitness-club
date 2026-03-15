<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user && $user->is_admin) {
            return redirect()->route('admin.dashboard');
        }
        
        
        return view('dashboard'); 
    }
}