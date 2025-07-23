<?php

use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DashboardApplicantController;
use App\Http\Controllers\DashboardCompanyController;
use App\Http\Controllers\JobVacancyController;
use App\Http\Controllers\PersonalApplicantController;
use App\Http\Controllers\PersonalCompanyController;
use App\Http\Controllers\ProfileController;
use Illuminate\Contracts\Queue\Job;
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

        // route kelola perusahaan
        Route::get('/companies', [DashboardAdminController::class, 'companyIndex'])->name('companies.index');
        Route::get('/companies/create', [DashboardAdminController::class, 'companyCreate'])->name('companies.create');
        Route::post('/companies/store', [DashboardAdminController::class, 'companyStore'])->name('companies.store');

        Route::get('/companies/profile/{user}/create', [DashboardAdminController::class, 'companyProfileCreate'])
            ->name('companies.profile.create');
        Route::post('/companies/profile/{user}/store', [DashboardAdminController::class, 'companyProfileStore'])
            ->name('companies.profile.store');

        Route::get(
            '/companies/profile/{personalCompany:slug_company}/show',
            [DashboardAdminController::class, 'companyProfileShow']
        )->name('companies.profile.show');

        // update perusahaan
        Route::get(
            '/companies/profile/{personalCompany:slug_company}/edit',
            [DashboardAdminController::class, 'companyProfileEdit']
        )->name('companies.profile.edit');
        Route::put(
            '/companies/profile/{personalCompany:slug_company}/update',
            [DashboardAdminController::class, 'companyProfileUpdate']
        )->name('companies.profile.update');
        Route::patch(
            '/companies/profile/{personalCompany:slug_company}/update-status-company',
            [DashboardAdminController::class, 'companyProfileUpdateStatus']
        )->name('companies.profile.update.status');

        // delete perusahaan
        Route::delete(
            '/companies/{user}/destroy',
            [DashboardAdminController::class, 'companyDestroy']
        )->name('companies.destroy');
    });
});

Route::middleware(['auth', 'role:company'])->group(function () {
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard-company', [DashboardCompanyController::class, 'index'])->name('dashboard');

        // edit profile
        Route::get('/profile/create', [PersonalCompanyController::class, 'create'])->name('profile.create');
        Route::post('/profile/store', [PersonalCompanyController::class, 'store'])->name('profile.store');

        Route::get(
            '/profile/{personalCompany:slug_company}/edit',
            [PersonalCompanyController::class, 'edit']
        )->name('profile.edit');
        Route::put(
            '/profile/{personalCompany:slug_company}/update',
            [PersonalCompanyController::class, 'update']
        )->name('profile.update');

        // lowongan
        Route::get(
            '/{personalCompany:slug_company}/jobs',
            [JobVacancyController::class, 'index']
        )->name('jobs.index');
        Route::get(
            '/{personalCompany:slug_company}/jobs/create',
            [JobVacancyController::class, 'create']
        )->name('jobs.create');
        Route::post(
            '/{personalCompany:slug_company}/jobs/store',
            [JobVacancyController::class, 'store']
        )->name('jobs.store');

        Route::get(
            '/{personalCompany:slug_company}/jobs/{jobVacancy:slug_job_position}/show',
            [JobVacancyController::class, 'show']
        )->name('jobs.show');

        // update lowongan
        Route::get(
            '/{personalCompany:slug_company}/jobs/{jobVacancy:slug_job_position}/edit',
            [JobVacancyController::class, 'edit']
        )->name('jobs.edit');
        Route::put(
            '/{personalCompany:slug_company}/jobs/{jobVacancy:slug_job_position}/update',
            [JobVacancyController::class, 'update']
        )->name('jobs.update');

        // delete lowongan
        Route::delete(
            '/{personalCompany:slug_company}/jobs/{jobVacancy:slug_job_position}/destroy',
            [JobVacancyController::class, 'destroy']
        )->name('jobs.destroy');
    });
});

Route::middleware(['auth', 'role:applicant'])->group(function () {
    Route::prefix('applicant')->name('applicant.')->group(function () {
        Route::get('/dashboard-applicant', [DashboardApplicantController::class, 'index'])->name('dashboard');

        // edit profile
        Route::get('/profile/create', [PersonalApplicantController::class, 'create'])->name('profile.create');
        Route::post('/profile/store', [PersonalapplicantController::class, 'store'])->name('profile.store');

        Route::get(
            '/profile/{personalApplicant:slug_applicant}/edit',
            [PersonalapplicantController::class, 'edit']
        )->name('profile.edit');
        Route::put(
            '/profile/{personalApplicant:slug_applicant}/update',
            [PersonalapplicantController::class, 'update']
        )->name('profile.update');
    });
});

require __DIR__ . '/auth.php';
