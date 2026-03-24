<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('subscription.member')
                          ->latest()
                          ->paginate(20);
        
        $totalReceived = Payment::where('status', 'completed')->sum('total_paid');
        $todayPayments = Payment::whereDate('payment_date', today())->sum('total_paid');
        $pendingCount = Payment::where('status', 'pending')->count();
        
        return view('admin.payments.index', compact('payments', 'totalReceived', 'todayPayments', 'pendingCount'));
    }

    public function create()
    {
        $subscriptions = Subscription::where('payment_status', 'pending')
                                    ->with('member')
                                    ->get();
        
        return view('admin.payments.create', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subscription_id' => 'required|exists:subscriptions,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,card,bank_transfer,check',
            'payment_date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $subscription = Subscription::findOrFail($request->subscription_id);
        
        $invoiceNumber = 'PAY-' . date('Ymd') . '-' . Str::random(6);
        
        $payment = Payment::create([
            'subscription_id' => $subscription->id,
            'invoice_number' => $invoiceNumber,
            'amount' => $subscription->total_amount,
            'total_paid' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_date' => $request->payment_date,
            'status' => 'completed',
            'notes' => $request->notes
        ]);

        // Mettre à jour l'abonnement
        $subscription->update([
            'payment_status' => 'paid',
            'payment_date' => $request->payment_date,
            'payment_method' => $request->payment_method
        ]);

        return redirect()->route('admin.payments.show', $payment)
                        ->with('success', 'Paiement enregistré avec succès');
    }

    public function show(Payment $payment)
    {
        $payment->load('subscription.member');
        return view('admin.payments.show', compact('payment'));
    }

    public function downloadReceipt(Payment $payment)
    {
        // Ici vous pouvez générer un PDF de reçu
        // Pour l'instant, on redirige juste
        return redirect()->back()->with('info', 'Fonctionnalité de génération de reçu à venir');
    }
}