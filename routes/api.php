<?php

use App\Http\Controllers\TouristController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Tourist Endpoints 

// GET /api/AllTourists  
Route::get('/AllTourists', [TouristController::class, 'index']);

// GET /api/TouristData/{id}  
Route::get('/TouristData/{id}', [TouristController::class, 'show']);

Route::get('/AllTouristsNumber', [TouristController::class, 'count']);

Route::patch('/TouristData/{id}', [TouristController::class, 'update']);

Route::delete('/TouristData/{id}', [TouristController::class, 'destroy']);