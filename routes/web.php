<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\AuthorityController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingsController;

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


// ECOTRACK PROTECTED ROUTES START


// 1. Normal End User (Customer) Routes
Route::middleware(['auth', 'role:normal end user'])->group(function () {
    Route::get('/requests/new', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/history', [RequestController::class, 'history'])->name('requests.history');
    Route::get('/requests/{wasteRequest}', [RequestController::class, 'show'])->name('requests.show');
});

// 2. Admin Secondary (Waste Authority) Routes
Route::middleware(['auth', 'role:admin secondary'])->prefix('authority')->name('authority.')->group(function () {
     // Main Assignments Dashboard
        Route::get('/assignments', [AuthorityController::class, 'index'])->name('assignments');
        
        // Action to assign a collector to a request
        Route::post('/assign/{requestId}', [AuthorityController::class, 'assign'])->name('assign');
        
        // Action to update the status of a request (THIS WAS THE MISSING ROUTE)
        Route::put('/tracking/{requestId}', [AuthorityController::class, 'updateTracking'])->name('updateTracking');

        // Live Tracking View
        Route::get('/tracking-view', [AuthorityController::class, 'trackingView'])->name('trackingView'); 
        
        
});

// 3. Admin Super User (Global Admin) Routes
Route::middleware(['auth', 'role:admin super user'])->prefix('admin')->name('admin.')->group(function () {
    // ReportController references App\Http\Controllers\Admin\ReportController
    Route::get('/reports', [AnalyticsController::class, 'index'])->name('reports');

    Route::get('/reports/data', [AnalyticsController::class, 'generateAnalytics'])->name('reports.analytics');
    
    // SettingsController references App\Http\Controllers\Admin\SettingsController
    Route::get('/settings', [SettingsController::class, 'index'])->name('system.settings');
});

Route::middleware('role:admin super user')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
});
// User creation view for admins
         Route::get('/admin/create-user', [RegisteredUserController::class, 'create'])
        ->name('admin.create-user');



require __DIR__.'/auth.php';
