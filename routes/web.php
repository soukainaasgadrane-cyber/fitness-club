<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\PaymentController;




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


Route::get('/payments', [PaymentController::class,'index'])->name('payments.index');

Route::get('/payments/create', [PaymentController::class,'create'])->name('payments.create');

Route::post('/payments', [PaymentController::class,'store'])->name('payments.store');

Route::get('/check-subscription/{id}', [PaymentController::class,'checkSubscription']);