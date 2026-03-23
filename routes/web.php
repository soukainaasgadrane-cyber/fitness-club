<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\Admin\FinanceController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;     
use App\Http\Controllers\ExerciseController;    
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\BMIController;         

use App\Http\Controllers\Admin\ProgramController as AdminProgramController;
use App\Http\Controllers\Admin\ExerciseController as AdminExerciseController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;



Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
     ->middleware(['auth', 'verified'])
     ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



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

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
Route::get('/bmi-calculator', [BMIController::class, 'index'])->name('bmi');

// المسارات المحمية (تحتاج تسجيل دخول)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('members', AdminMemberController::class);
});

require __DIR__.'/auth.php';

Route::resource('payments', PaymentController::class);

Route::get('/check-subscription/{id}', 
    [PaymentController::class,'checkSubscription']);

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/create', [PaymentController::class, 'create'])->name('payments.create');
Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');