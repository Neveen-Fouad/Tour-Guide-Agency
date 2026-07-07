<?php

use App\Http\Controllers\TouristController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



// Tourist Endpoints 

// GET /api/AllTourists  
Route::get('/AllTourists', [TouristController::class, 'index']);

// GET /api/TouristData/{id}  
Route::get('/TouristData/{id}', [TouristController::class, 'show']);

