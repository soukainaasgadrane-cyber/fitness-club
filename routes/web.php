<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BMIController;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{id}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');

Route::get('/bmi-calculator', [BMIController::class, 'index'])->name('bmi');
Route::post('/bmi-calculator', [BMIController::class, 'index'])->name('bmi.calculate');

Route::get('/contact', fn() => view('contact'))->name('contact');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Finance
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');


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



Route::get('/payments', [PaymentController::class,'index'])->name('payments.index');

Route::get('/payments/create', [PaymentController::class,'create'])->name('payments.create');

Route::post('/payments', [PaymentController::class,'store'])->name('payments.store');

Route::get('/check-subscription/{id}', [PaymentController::class,'checkSubscription']);
Route::get('/payer', function(){
    return view('paiement');
});

Route::post('/payer', [PaymentController::class,'payer'])->name('payer');
    // Subscriptions (resourceful)
    Route::resource('subscriptions', SubscriptionController::class);

    // Extra actions
    Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])->name('subscriptions.renew');
    Route::post('/subscriptions/{subscription}/payment', [SubscriptionController::class, 'addPayment'])->name('subscriptions.payment');

    // Payments
    Route::get('/payments/export/csv', [PaymentController::class, 'export'])->name('payments.export');
    Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund'])->name('payments.refund');
    Route::resource('payments', PaymentController::class)->only(['index','show']);

    // Members
    Route::resource('members', AdminMemberController::class);
});

/*
|--------------------------------------------------------------------------
| TEST ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/test-soukaina', fn() => 'soukaina fonctionne !');

require __DIR__.'/auth.php';

