<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Announcement;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WasteController;
use App\Http\Controllers\Admin\AdminDashboardController;




Route::get('/', function () {
    try {
        $beritaTerkini = \App\Models\Announcement::latest()->take(3)->get();
    } catch (\Exception $e) {
        $beritaTerkini = [];
    }

    return view('welcome', compact('beritaTerkini'));
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
//Waste 
    Route::get('/waste/select', function () {return view('waste.select');})->name('waste.select');
    Route::get('/waste/form', [WasteController::class, 'create']);
    Route::post('/waste/preview', [WasteController::class, 'preview']);
    Route::post('/waste/store', [WasteController::class, 'store']);
    Route::get('/waste/success', [WasteController::class, 'success']);   
    
//Guidelines & Rules 
    Route::get('/waste/guidelines', function () {return view('waste.guidelines');})->name('waste.guidelines');
    Route::get('/process-flow', function () {return view('waste.process-flow');})->name('process.flow');
    Route::get('/waste/process', function () {return view('waste.process');})->name('waste.process');
    Route::get('/panduan-setor', function () {return view('waste.panduan-setor');})->name('panduan.setor');
    Route::get('/rules', function () {return view('waste.rules');})->name('rules');

//Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
});

// ==================== PUBLIC PAGES ====================
Route::get('/about', function () { return view('pages.about'); })->name('about');
Route::get('/contact', function () { return view('pages.contact'); })->name('contact');

// ==================== ADMIN ROUTES ====================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
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

    // Educations
    Route::get('/educations', [AdminDashboardController::class, 'educations'])->name('educations');
    Route::post('/educations', [AdminDashboardController::class, 'storeEducation'])->name('educations.store');
    Route::delete('/educations/{education}', [AdminDashboardController::class, 'deleteEducation'])->name('educations.delete');
});

require __DIR__.'/auth.php';
