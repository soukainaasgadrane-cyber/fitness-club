<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\FinanceController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BMIController;

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('home');
})->name('home');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/programs', [ProgramController::class, 'index'])->name('programs.index');
Route::get('/programs/{id}', [ProgramController::class, 'show'])->name('programs.show');

Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');

Route::get('/bmi-calculator', [BMIController::class, 'index'])->name('bmi');
Route::post('/bmi-calculator', [BMIController::class, 'index'])->name('bmi.calculate');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // Finance
    Route::get('/finance', [FinanceController::class, 'index'])
        ->name('finance.index');

    // Subscriptions
    Route::get('/subscriptions', [SubscriptionController::class, 'index'])
        ->name('subscriptions.index');

    Route::get('/subscriptions/create', [SubscriptionController::class, 'create'])
        ->name('subscriptions.create');

    Route::post('/subscriptions', [SubscriptionController::class, 'store'])
        ->name('subscriptions.store');

    Route::get('/subscriptions/{subscription}', [SubscriptionController::class, 'show'])
        ->name('subscriptions.show');

    Route::get('/subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])
        ->name('subscriptions.edit');

    Route::put('/subscriptions/{subscription}', [SubscriptionController::class, 'update'])
        ->name('subscriptions.update');

    Route::delete('/subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
        ->name('subscriptions.destroy');

    Route::post('/subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
        ->name('subscriptions.renew');

    Route::post('/subscriptions/{subscription}/payment', [SubscriptionController::class, 'addPayment'])
        ->name('subscriptions.payment');

    // Payments
    Route::get('/payments', [PaymentController::class, 'index'])
        ->name('payments.index');

    Route::get('/payments/{payment}', [PaymentController::class, 'show'])
        ->name('payments.show');

    Route::post('/payments/{payment}/refund', [PaymentController::class, 'refund'])
        ->name('payments.refund');

    Route::get('/payments/export/csv', [PaymentController::class, 'export'])
        ->name('payments.export');

    // Members
    Route::resource('members', AdminMemberController::class);
});

/*
|--------------------------------------------------------------------------
| TEST ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/test-soukaina', function () {
    return 'soukaina fonctionne !';
});
// Routes 
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/subscriptions', [App\Http\Controllers\Admin\SubscriptionController::class, 'index'])->name('admin.subscriptions.index');
    Route::get('/subscriptions/create', [App\Http\Controllers\Admin\SubscriptionController::class, 'create'])->name('admin.subscriptions.create');
    Route::post('/subscriptions', [App\Http\Controllers\Admin\SubscriptionController::class, 'store'])->name('admin.subscriptions.store');
    Route::get('/subscriptions/{subscription}', [App\Http\Controllers\Admin\SubscriptionController::class, 'show'])->name('admin.subscriptions.show');
    
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
    Route::get('/payments/export/csv', [App\Http\Controllers\Admin\PaymentController::class, 'export'])->name('admin.payments.export');
    
    Route::get('/finance', [App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('admin.finance.index');
});
require __DIR__.'/auth.php';