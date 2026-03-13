<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    /**
     * Affiche le tableau de bord financier
     */
    public function index()
    {
        // Statistiques de base
        $stats = [
            'today_revenue' => Payment::whereDate('payment_date', today())->sum('amount') ?? 0,
            'month_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount') ?? 0,
            'year_revenue' => Payment::whereYear('payment_date', now()->year)->sum('amount') ?? 0,
            'active_subscriptions' => Subscription::where('is_active', true)->count() ?? 0,
        ];
        
        return view('admin.finance.index', compact('stats'));
    }
}