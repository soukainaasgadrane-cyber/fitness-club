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

require __DIR__.'/auth.php';
