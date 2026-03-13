<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $stats = [
            'today_revenue' => Payment::whereDate('payment_date', today())->sum('amount'),
            'month_revenue' => Payment::whereMonth('payment_date', now()->month)->sum('amount'),
            'year_revenue' => Payment::whereYear('payment_date', now()->year)->sum('amount'),
            'active_subscriptions' => Subscription::where('is_active', true)->count(),
        ];
        
        return view('admin.finance.index', compact('stats'));
    }
}