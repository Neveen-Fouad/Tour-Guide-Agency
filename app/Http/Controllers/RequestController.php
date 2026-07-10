<?php

namespace App\Http\Controllers;

use App\Http\Resources\RequestsRescource;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Request as TourRequest;

class RequestController extends Controller
{
     public function index()
    {
        $requests = TourRequest::with('review', 'tourGuide', 'tourist')->get();
         Gate::authorize('view', TourRequest::class);
        return response()->json($requests);
    }

    public function getByTouristId($id)
    {
       
        $requests = TourRequest::where('Tourist_id', $id)->with('tourGuide')->get();
         Gate::authorize('view', TourRequest::class);
        return response()->json($requests);
    }

    public function getByTourGuideId($id)
    {
       
        $requests = TourRequest::where('Tour_Guide_id', $id)->where('status', 'pending')->with('tourist')->get();
         Gate::authorize('view', TourRequest::class);
        return RequestsRescource::collection($requests);
    }

    public function store(Request $request)
    {
         Gate::authorize('create', TourRequest::class);
        $validatedData = $request->validate([
            'Tourist_id' => 'required|exists:tourists,id',
            'TourGuide_id' => 'required|exists:tour_guides,id',
            'destination' => 'required|string|max:255',
            'arrival_time' => 'required|date',
            'departure_time' => 'required|date|after:arival_time',
            'plan' => 'nullable|string|max:1000',
        ]);
     
        $request = TourRequest::create($validatedData);

        return response()->json($request, 201);
    }
    public function countRequests($id)
    {
        
        $count = TourRequest::where('Tour_Guide_id', $id)->count();
        Gate::authorize('view', TourRequest::class);
        return response()->json(['count' => $count]);
    }
    public function CountAcceptedRequests($id)
    {
      
        $count = TourRequest::where('Tour_Guide_id', $id)->where('status', 'accepted')->count();
          Gate::authorize('view', TourRequest::class);
        return response()->json(['count' => $count]);
    }
//  admin
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $tourRequest = TourRequest::findOrFail($id);
        Gate::authorize('update', $tourRequest);
        $tourRequest->update($validatedData);

        return response()->json($tourRequest);
    }

    public function updateApprovalStatus(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'is_approved' => 'required|boolean',
        ]);

        $tourRequest = TourRequest::findOrFail($id);
        Gate::authorize('update', TourRequest::class);
        $tourRequest->update($validatedData);

        return response()->json($tourRequest);
    }
}


