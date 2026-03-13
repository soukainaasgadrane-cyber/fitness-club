<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\FinanceController;





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

require __DIR__.'/auth.php';



// ===========================================
// ADMIN ROUTES - PROTÉGÉES PAR AUTH ET ADMIN
// ===========================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // ===========================================
    // 1. DASHBOARD FINANCIER
    // ===========================================
    Route::get('/finance', [FinanceController::class, 'index'])
         ->name('finance.index'); // admin.finance.index
    
    // ===========================================
    // 2. GESTION DES ABONNEMENTS (SUBSCRIPTIONS)
    // ===========================================
    
    // Liste des abonnements avec filtres
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])
         ->name('subscriptions.index'); // admin.subscriptions.index
    
    // Formulaire de création
    Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])
         ->name('subscriptions.create'); // admin.subscriptions.create
    
    // Enregistrer un nouvel abonnement
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])
         ->name('subscriptions.store'); // admin.subscriptions.store
    
    // Voir les détails d'un abonnement
    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])
         ->name('subscriptions.show'); // admin.subscriptions.show
    
    // Formulaire de modification
    Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])
         ->name('subscriptions.edit'); // admin.subscriptions.edit
    
    // Mettre à jour un abonnement
    Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])
         ->name('subscriptions.update'); // admin.subscriptions.update
    
    // Supprimer un abonnement
    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
         ->name('subscriptions.destroy'); // admin.subscriptions.destroy
    
    // RENOUVELER un abonnement
    Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
         ->name('subscriptions.renew'); // admin.subscriptions.renew
    
    // AJOUTER UN PAIEMENT à un abonnement
    Route::post('/subscriptions/{subscription}/payment', [SubscriptionController::class, 'addPayment'])
         ->name('subscriptions.payment'); // admin.subscriptions.payment
    
    // ===========================================
    // 3. GESTION DES PAIEMENTS (PAYMENTS)
    // ===========================================
    
    // Liste des paiements avec filtres
    Route::get('/payments', [PaymentController::class, 'index'])
         ->name('payments.index'); // admin.payments.index
    
    // Voir les détails d'un paiement
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])
         ->name('payments.show'); // admin.payments.show
    
    // REMBOURSER un paiement
    Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund'])
         ->name('payments.refund'); // admin.payments.refund
    
    // EXPORTER les paiements en CSV
    Route::get('/payments/export/csv', [PaymentController::class, 'export'])
         ->name('payments.export'); // admin.payments.export
});
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/finance', [FinanceController::class, 'index'])->name('finance.index');
});