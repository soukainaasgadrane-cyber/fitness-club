<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// ==================== ROUTES GHITA ====================
Route::get('/admin/subscriptions', function() {
    return view('admin.subscriptions.index');
})->middleware(['auth'])->name('admin.subscriptions.index');

Route::get('/admin/payments', function() {
    return view('admin.payments.index');
})->middleware(['auth'])->name('admin.payments.index');

Route::get('/admin/finance', function() {
    return view('admin.finance.index');
})->middleware(['auth'])->name('admin.finance.index');

// Routes pour les abonnements
Route::get('/admin/subscriptions', function() {
    return view('admin.subscriptions.index');
})->name('admin.subscriptions.index');

Route::get('/admin/subscriptions/create', function() {
    return view('admin.subscriptions.create');
})->name('admin.subscriptions.create');

Route::post('/admin/subscriptions', function() {
    return redirect()->route('admin.subscriptions.index')->with('success', 'Abonnement créé');
})->name('admin.subscriptions.store');
Route::get('/admin/subscriptions/{id}', function($id) {
    $subscription = App\Models\Subscription::find($id);
    if (!$subscription) {
        return redirect()->route('admin.subscriptions.index')->with('error', 'Abonnement non trouvé');
    }
    return view('admin.subscriptions.show', compact('subscription'));
})->name('admin.subscriptions.show');
// Route pour afficher la liste des abonnements
Route::get('/admin/subscriptions', function() {
    $subscriptions = App\Models\Subscription::with(['member', 'plan'])->latest()->get();
    return view('admin.subscriptions.index', compact('subscriptions'));
})->name('admin.subscriptions.index');
// Routes pour les paiements
Route::get('/admin/payments', function() {
    $payments = App\Models\Payment::with(['subscription.member'])->latest()->get();
    $totalReceived = App\Models\Payment::where('status', 'completed')->sum('amount');
    $todayPayments = App\Models\Payment::whereDate('payment_date', today())->where('status', 'completed')->sum('amount');
    $pendingCount = App\Models\Payment::where('status', 'pending')->count();
    
    return view('admin.payments.index', compact('payments', 'totalReceived', 'todayPayments', 'pendingCount'));
})->name('admin.payments.index');

Route::get('/admin/payments/{id}', function($id) {
    $payment = App\Models\Payment::with(['subscription.member'])->find($id);
    if (!$payment) {
        return redirect()->route('admin.payments.index')->with('error', 'Paiement non trouvé');
    }
    return view('admin.payments.show', compact('payment'));
})->name('admin.payments.show');

Route::get('/admin/payments/export/csv', function() {
    $payments = App\Models\Payment::with(['subscription.member'])->where('status', 'completed')->get();
    
    $filename = 'paiements_' . date('Y-m-d') . '.csv';
    $handle = fopen('php://temp', 'w+');
    
    fputcsv($handle, ['Facture', 'Membre', 'Email', 'Montant', 'Méthode', 'Date', 'Statut']);
    
    foreach ($payments as $payment) {
        fputcsv($handle, [
            $payment->invoice_number ?? $payment->id,
            $payment->subscription->member->full_name ?? 'N/A',
            $payment->subscription->member->email ?? 'N/A',
            number_format($payment->amount, 2),
            $payment->payment_method,
            $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-',
            $payment->status
        ]);
    }
    
    rewind($handle);
    $content = stream_get_contents($handle);
    fclose($handle);
    
    return response($content)
        ->header('Content-Type', 'text/csv; charset=utf-8')
        ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
})->name('admin.payments.export');
// Admin Dashboard (Soukaina + Ghita)
Route::get('/admin/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
// Routes pour les membres (Soukaina)
Route::get('/admin/members', function() {
    $members = App\Models\Member::latest()->paginate(10);
    return view('admin.members.index', compact('members'));
})->name('admin.members.index');

Route::get('/admin/members/create', function() {
    return view('admin.members.create');
})->name('admin.members.create');

Route::post('/admin/members', function() {
    return redirect()->route('admin.members.index')->with('success', 'Membre ajouté');
})->name('admin.members.store');

Route::get('/admin/members/{member}', function($id) {
    $member = App\Models\Member::find($id);
    return view('admin.members.show', compact('member'));
})->name('admin.members.show');

Route::get('/admin/members/{member}/edit', function($id) {
    $member = App\Models\Member::find($id);
    return view('admin.members.edit', compact('member'));
})->name('admin.members.edit');

Route::put('/admin/members/{member}', function($id) {
    return redirect()->route('admin.members.index')->with('success', 'Membre modifié');
})->name('admin.members.update');

Route::delete('/admin/members/{member}', function($id) {
    return redirect()->route('admin.members.index')->with('success', 'Membre supprimé');
})->name('admin.members.destroy');

require __DIR__.'/auth.php';
