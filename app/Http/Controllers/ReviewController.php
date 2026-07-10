<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\TourGuide;
use Illuminate\Http\Request;
use App\Models\Request as TourRequest;
use Illuminate\Support\Facades\Gate;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('tourist', 'request.tourGuide')->get();
        return ReviewResource::collection($reviews);
    }

    // public function getByTouristId()

    public function getByTourGuideId($id){
      TourGuide::findOrFail($id);
        $reviews = Review::with(['tourist', 'request.tourGuide'])
            ->whereHas('request', function ($query) use ($id) {
                $query->where('Tour_Guide_id', $id); 
            })
            ->get();

        // 3. Pass the clean, eager-loaded collection to the Resource
        return ReviewResource::collection($reviews);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'Tourist_id' => 'required|exists:tourists,id',
            'Request_id' => 'required|exists:requests,id',
        ]);

        $review = Review::create($validatedData);

        return response()->json($review, 201);
    }


    public function starFiltration($starRating)
    {
      if (!is_numeric($starRating) || $starRating < 1 || $starRating > 5) {
            return response()->json(['message' => 'Rating must be an integer between 1 and 5'], 422);
        }
        $reviews = Review::where('rating', $starRating)->get();
        
        return response()->json($reviews);
    }



  public function getGuideAverageRating($id)
    {
        $guide = TourGuide::findOrFail($id);
        $average = Review::whereHas('request.tourGuide', function ($query) use ($id) {
            $query->where('Tour_Guide_id', $id);
        })->avg('rating');
        $formattedAverage = round((float) ($average ?? 0), 1);
        return response()->json([
            'tour_guide_id' => $guide->id,
            'average_rating' => $formattedAverage 
        ]);
    }

    public function reviewStats()
    {
        for ($rating = 1; $rating <= 5; $rating++) {
            $count = Review::where('rating', $rating)->count();
            $stats[$rating] = $count;
        }
        return response()->json($stats);
    }
 
    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
