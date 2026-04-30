<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CollectionPointController;

Route::get('/collection-points', [CollectionPointController::class, 'index']);
