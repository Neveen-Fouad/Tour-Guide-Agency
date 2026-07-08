<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\ReviewController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/GuideData/name/{name}', [TourGuideController::class, 'getByName']);
Route::get('/GuideData/area/{area}', [TourGuideController::class, 'getByArea']);
Route::get('/GuideData/PricePerHour/{price}', [TourGuideController::class, 'getByPrice']);
Route::get('/GuideData/Languages/{language}', [TourGuideController::class, 'getByLanguage']);
Route::get('/ApprovedGuidesNumber', [TourGuideController::class, 'approvedCount']);
Route::get('/PendingGuidesNumber', [TourGuideController::class, 'pendingCount']);


Route::get('/GuideData/id/{id}', [TourGuideController::class,'getById']);
Route::get('/AllGuides/page',[TourGuideController::class,'getAllPaginated']);
Route::patch('/GuideData/id/{id}', [TourGuideController::class, 'update']);
Route::delete('/GuideData/id/{id}', [TourGuideController::class, 'destroy']);
Route::patch('/ApprovalStatus', [TourGuideController::class, 'updateApprovalStatus']);


Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/tourGuide/{id}', [ReviewController::class, 'getByTourGuideId']);
Route::get('/reviews/star/{starRating}', [ReviewController::class, 'starFiltration']);
Route::get('/reviews/averageRating/{id}', [ReviewController::class, 'getGuideAverageRating']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/stats', [ReviewController::class, 'reviewStats']);
