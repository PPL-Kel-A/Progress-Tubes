<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\EducationController;

// ==================== HOME ====================
Route::get('/', function () {
    try {
        $beritaTerkini = \App\Models\Announcement::latest()->take(3)->get();
    } catch (\Exception $e) {
        $beritaTerkini = [];
    }

    return view('welcome', compact('beritaTerkini'));
});

// ==================== DASHBOARD ====================
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ==================== USER ====================
Route::middleware('auth')->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Waste
    Route::get('/waste/select', fn () => view('waste.select'))->name('waste.select');
    Route::get('/waste/form', [WasteController::class, 'create']);
    Route::post('/waste/preview', [WasteController::class, 'preview']);
    Route::post('/waste/store', [WasteController::class, 'store']);
    Route::get('/waste/success', [WasteController::class, 'success']);

    // Guidelines
    Route::get('/waste/guidelines', fn () => view('waste.guidelines'))->name('waste.guidelines');
    Route::get('/process-flow', fn () => view('waste.process-flow'))->name('process.flow');
    Route::get('/waste/process', fn () => view('waste.process'))->name('waste.process');
    Route::get('/panduan-setor', fn () => view('waste.panduan-setor'))->name('panduan.setor');
    Route::get('/rules', fn () => view('waste.rules'))->name('rules');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

    // Announcements (user-facing)
    Route::get('/announcements', [DashboardController::class, 'announcements'])->name('announcements.index');
});

// ==================== PUBLIC ====================
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');

// ==================== EDUCATION USER ====================
Route::get('/education', [EducationController::class, 'index'])->name('education.index');

// ==================== ADMIN ====================
Route::middleware(['auth', 'is_admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::get('/users', [AdminDashboardController::class, 'users'])->name('users');
    Route::put('/users/{user}', [AdminDashboardController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminDashboardController::class, 'deleteUser'])->name('users.delete');

    // Wastes
    Route::get('/wastes', [AdminDashboardController::class, 'wastes'])->name('wastes');
    Route::delete('/wastes/{waste}', [AdminDashboardController::class, 'deleteWaste'])->name('wastes.delete');

    // Reports
    Route::get('/reports', [AdminDashboardController::class, 'reports'])->name('reports');
    Route::put('/reports/{report}/status', [AdminDashboardController::class, 'updateReportStatus'])->name('reports.status');

    // Rewards
    Route::get('/rewards', [AdminDashboardController::class, 'rewards'])->name('rewards');
    Route::post('/rewards', [AdminDashboardController::class, 'storeReward'])->name('rewards.store');
    Route::delete('/rewards/{reward}', [AdminDashboardController::class, 'deleteReward'])->name('rewards.delete');

    // Schedules
    Route::get('/schedules', [AdminDashboardController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [AdminDashboardController::class, 'storeSchedule'])->name('schedules.store');
    Route::put('/schedules/{schedule}', [AdminDashboardController::class, 'updateSchedule'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [AdminDashboardController::class, 'deleteSchedule'])->name('schedules.delete');

    // Announcements
    Route::get('/announcements', [AdminDashboardController::class, 'announcements'])->name('announcements');
    Route::post('/announcements', [AdminDashboardController::class, 'storeAnnouncement'])->name('announcements.store');
    Route::put('/announcements/{announcement}', [AdminDashboardController::class, 'updateAnnouncement'])->name('announcements.update');
    Route::delete('/announcements/{announcement}', [AdminDashboardController::class, 'deleteAnnouncement'])->name('announcements.delete');

    // ==================== EDUCATIONS (FULL CRUD) ====================

    // LIST
    Route::get('/educations', [AdminDashboardController::class, 'educations'])->name('educations');

    // CREATE
    Route::post('/educations', [AdminDashboardController::class, 'storeEducation'])->name('educations.store');

    // DELETE
    Route::delete('/educations/{education}', [AdminDashboardController::class, 'deleteEducation'])->name('educations.delete');

    // EDIT PAGE
    Route::get('/educations/{education}/edit', [AdminDashboardController::class, 'edit'])->name('educations.edit');

    // UPDATE
    Route::put('/educations/{education}', [AdminDashboardController::class, 'update'])->name('educations.update');

});

require __DIR__.'/auth.php';