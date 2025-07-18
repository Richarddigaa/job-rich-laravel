<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardApplicantController;
use App\Http\Controllers\DashboardCompanyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard-admin', [DashboardAdminController::class, 'index'])->name('dashboard');
    });
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard-company', [DashboardCompanyController::class, 'index'])->name('dashboard');
    });
});

Route::middleware(['auth', 'role:applicant'])->group(function () {
    Route::prefix('applicant')->name('applicant.')->group(function () {
        Route::get('/dashboard-applicant', [DashboardApplicantController::class, 'index'])->name('dashboard');
    });
});

require __DIR__ . '/auth.php';
