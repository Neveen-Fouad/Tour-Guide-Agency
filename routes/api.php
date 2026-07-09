<?php
use App\Http\Controllers\TouristController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TourGuideController;
use App\Http\Controllers\ReviewController;

// jwt.verify middleware => user must be logged in
// admin middleware => admin only access

Route::get('/GuideData/name/{name}', [TourGuideController::class, 'getByName']);
Route::get('/GuideData/area/{area}', [TourGuideController::class, 'getByArea']);
Route::get('/GuideData/PricePerHour/{price}', [TourGuideController::class, 'getByPrice']);
Route::get('/GuideData/Languages/{language}', [TourGuideController::class, 'getByLanguage']);
Route::get('/ApprovedGuidesNumber', [TourGuideController::class, 'approvedCount']);
Route::get('/PendingGuidesNumber', [TourGuideController::class, 'pendingCount']);


Route::get('/GuideData/id/{id}', [TourGuideController::class,'getById']);
Route::get('/AllGuides/page',[TourGuideController::class,'getAllPaginated']);
Route::middleware('jwt.verify')->patch('/GuideData/id/{id}', [TourGuideController::class, 'update']);
Route::middleware('admin')->group(function () {
Route::delete('/GuideData/id/{id}', [TourGuideController::class, 'destroy']);
Route::patch('/ApprovalStatus', [TourGuideController::class, 'updateApprovalStatus']);
});
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/tourGuide/{id}', [ReviewController::class, 'getByTourGuideId']);
Route::get('/reviews/star/{starRating}', [ReviewController::class, 'starFiltration']);
Route::get('/reviews/averageRating/{id}', [ReviewController::class, 'getGuideAverageRating']);
Route::middleware('jwt.verify')->post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/stats', [ReviewController::class, 'reviewStats']);




// Tourist Endpoints 

// GET /api/AllTourists 
Route::middleware('admin')->get('/AllTourists', [TouristController::class, 'index']);

// GET /api/TouristData/{id}  
Route::get('/TouristData/{id}', [TouristController::class, 'show']);

Route::get('/AllTouristsNumber', [TouristController::class, 'count']);

Route::middleware('jwt.verify')->patch('/TouristData/{id}', [TouristController::class, 'update']);

Route::middleware('admin')->delete('/TouristData/{id}', [TouristController::class, 'destroy']);

// auth
Route::post('/TouristAuth',[AuthController::class,'registerTourist']);
Route::post('/GuideAuth',[AuthController::class,'registerTourGuide']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/forgetPassword',[AuthController::class,'forgetPassword']);
Route::post('/resetPassword',[AuthController::class,'resetPassword']);
Route::middleware('jwt.verify')->group(function () {
    Route::post('/logout',[AuthController::class,'logout']);
    Route::post('/refresh',[AuthController::class,'refresh']);
    Route::get('/profile',[AuthController::class,'me']);
});