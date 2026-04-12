<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Announcement;
use App\Http\Controllers\ReportController;

Route::get('/reports', [ReportController::class, 'index'])
    ->name('reports.index');

// Route::get('/', function () {
//     $beritaTerkini = Announcement::latest()->take(3)->get();
//     return view('welcome', compact('beritaTerkini'));
// });

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
});

require __DIR__.'/auth.php';
