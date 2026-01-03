<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\TrainerController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;

/*
|--------------------------------------------------------------------------
| Public Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing'); // resources/views/landing.blade.php
})->name('landing');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Protected Routes (Admin Dashboard)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Members
    Route::resource('members', MemberController::class);

    // Trainers
    Route::resource('trainers', TrainerController::class);
    Route::post('/trainers/{trainer}/activate', [TrainerController::class, 'activate'])->name('trainers.activate');
    Route::post('/trainers/{trainer}/deactivate', [TrainerController::class, 'deactivate'])->name('trainers.deactivate');

    // Plans
    Route::resource('plans', PlanController::class);
    Route::patch('/plans/{id}/toggle-status', [PlanController::class, 'toggleStatus'])->name('plans.toggle-status');

    // Payments
    Route::resource('payments', PaymentController::class);
    Route::get('/payments/{payment}/invoice', [PaymentController::class, 'invoice'])->name('payments.invoice');
    Route::get('/payments/{payment}/invoice/download', [PaymentController::class, 'downloadInvoice'])->name('payments.invoice.download');
    Route::get('/payments/{payment}/invoice/print', [PaymentController::class, 'printInvoice'])->name('payments.invoice.print');
    Route::put('/payments/{payment}/update-status', [PaymentController::class, 'updateStatus'])->name('payments.update-status');

    // Attendance
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::get('/today', [AttendanceController::class, 'today'])->name('today');
        Route::get('/create', [AttendanceController::class, 'create'])->name('create');
        Route::post('/', [AttendanceController::class, 'store'])->name('store');
        Route::get('/{id}', [AttendanceController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AttendanceController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AttendanceController::class, 'update'])->name('update');
        Route::delete('/{id}', [AttendanceController::class, 'destroy'])->name('destroy');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Settings
    Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::post('/settings/maintenance', [SettingsController::class, 'maintenance'])->name('settings.maintenance');
});
