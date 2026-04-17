<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Announcement;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WasteController;

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
});

require __DIR__.'/auth.php';
