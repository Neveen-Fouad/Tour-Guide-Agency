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
        $requests = $requests->filter(function ($request) {
            return Gate::allows('view', $request);
        });
        return response()->json($requests);
    }

    public function getByTouristId($id)
    {
       
        $requests = TourRequest::where('Tourist_id', $id)->with('tourGuide')->get();
        $requests = $requests->filter(function ($request) {
            return Gate::allows('view', $request); 
        });
        return response()->json($requests->values());
    }

    public function getByTourGuideId($id)
    {
       
        $requests = TourRequest::where('Tour_Guide_id', $id)->where('status', 'pending')->with('tourist')->get();
        $requests = $requests->filter(function ($request) {
            return Gate::allows('view', $request);
        });        
         return RequestsRescource::collection($requests);
    }

    public function store(Request $request)
    {
         Gate::authorize('create', TourRequest::class);
        $validatedData = $request->validate([
            'Tourist_id' => 'required|exists:tourists,id',
            'Tour_Guide_id' => 'required|exists:tour_guides,id',
            'destination' => 'required|string|max:255',
            'arrival_time' => 'required|date',
            'departure_time' => 'required|date|after:arrival_time',
            'plan' => 'nullable|string|max:1000',
        ]);
     
        $request = TourRequest::create($validatedData);

        return response()->json($request, 201);
    }
    public function countRequests($id)
    {
        
        $count = TourRequest::where('Tour_Guide_id', $id)->count();
        $user = auth()->user();
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        
        if (!$isAdmin) {
            $tourGuide = \App\Models\TourGuide::find($id);
            if (!$tourGuide || $user->id != $id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }        
        return response()->json(['count' => $count]);
    }
    public function CountAcceptedRequests($id)
    {
      
        $count = TourRequest::where('Tour_Guide_id', $id)->where('status', 'accepted')->count();
        $user = auth()->user();
        $isAdmin = in_array($user->email, config('admin.emails'), true);
        
        if (!$isAdmin) {
            $tourGuide = \App\Models\TourGuide::find($id);
            if (!$tourGuide || $user->id != $id) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }        return response()->json(['count' => $count]);
    }
//  admin
    public function update(Request $request, $id)
    {
        $tourRequest = TourRequest::findOrFail($id);
        Gate::authorize('update', $tourRequest);
        $validatedData = $request->validate([
            'status' => 'required|in:pending,accepted,rejected',
        ]);

        $tourRequest->update($validatedData);

        return response()->json($tourRequest);
    }

    public function updateApprovalStatus(Request $request, $id)
    {
        $tourRequest = TourRequest::findOrFail($id);
        Gate::authorize('update', $tourRequest);
        $validatedData = $request->validate([
            'is_approved' => 'required|boolean',
        ]);


        $tourRequest->update($validatedData);

        return response()->json($tourRequest);
    }
}


