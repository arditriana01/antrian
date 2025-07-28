<?php

use App\Http\Controllers\QueueServicesController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Staff\AuthController as StaffAuth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Route for show queue
Route::get('/display', fn () => inertia('Display'))->name('staff.display');
Route::get('/display-queue', [QueueServicesController::class, 'getCurrentQueue']);


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Route for user queue reservation
Route::middleware(['auth', 'verified'])->group(function(){
    Route::get('/reservasi', [QueueServicesController::class, 'indexReservation'])->name('reservation.index');
    Route::post('/reservasi/store', [QueueServicesController::class, 'storeReservation'])->name('reservation.store');
});


// Route for staff
Route::prefix('staff')->group(function(){
    Route::middleware('guest:staff')->group(function(){
        Route::get('/login', [StaffAuth::class, 'showLogin'])->name('staff.login');
        Route::post('/login', [StaffAuth::class, 'login']);
    });
    
    Route::middleware('auth:staff')->group(function () {                        
        Route::get('/dashboard', [StaffController::class, 'index'])->name('staff.dashboard');        
        Route::get('/dashboard/data', [StaffController::class, 'getMonitoringData']);

        Route::post('/logout', [StaffAuth::class, 'logout'])->name('staff.logout');
        
        Route::get('/antri', [QueueServicesController::class, 'indexWalkin'])->name('walkin.index');
        Route::post('/antri/store', [QueueServicesController::class, 'storeWalkin'])->name('walkin.store');
        
        Route::get('/panggil', [QueueServicesController::class, 'IndexNextQueue'])->name('staff.callNext');
        Route::post('/call-next', [QueueServicesController::class, 'callNextQueue'])->name('queue.callNext');
        Route::post('/queues/finish', [QueueServicesController::class, 'finishCurrentQueue'])->name('queue.finish');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
