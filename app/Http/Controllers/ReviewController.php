<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Models\TourGuide;
use Illuminate\Http\Request;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::with('tourist', 'tourGuide')->get();
        return ReviewResource::collection($reviews);
    }

    // public function getByTouristId()

    public function getByTourGuideId($id){
       $guide = TourGuide::FindOrFail($id);
       $reviews = $guide->reviews;
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


    public function starFiltration(Request $request)
    {
        $starRating = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ])['rating'];
        $reviews = Review::where('rating', $starRating)->get();
        return response()->json($reviews);
    }



    public function getGuideAverageRating($id)
    {
        $guide = TourGuide::findOrFail($id);

        $average = $guide->reviews()->avg('rating');
        
        $formattedAverage = round((float) ($average ?? 0), 1);
          
        $formattedAverage = round($average);


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
