<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourGuide;
use Illuminate\Support\Facades\Cache;

class TourGuideController extends Controller
{


//guides whose name matches
public function getByName($name)
{
    $guides = TourGuide::where('name', 'like', '%' . $name . '%')->get();
    return response()->json($guides);
}

//all guides in a given area
public function getByArea($area)
{
    $guides = TourGuide::where('area', 'like', '%' . $area . '%')->get();
    return response()->json($guides);
}

//guides at or under a price
public function getByPrice($price)
{
    $guides = TourGuide::where('price_per_hour', '<=', $price)->get();
    return response()->json($guides);
}

//guides who speak a given language
public function getByLanguage($language)
{
    $guides = TourGuide::whereHas('languages', function ($query) use ($language) {
        $query->where('language', 'like', '%' . $language . '%');
    })->get();

    return response()->json($guides);
}


//Approved Guides Number
public function approvedCount()
{
    $count = Cache::remember('approved_guides_count', 600, function () {
        return TourGuide::where('is_approved', true)->count();
    });

    return response()->json(['No_of_guides' => $count]);
}

//Pending Guides Number
public function pendingCount()
{
    $count = Cache::remember('pending_guides_count', 600, function () {
        return TourGuide::where('is_approved', false)->count();
    });

    return response()->json(['No_of_pending_guides' => $count]);
}

//single guide by id
public function getById($id)
{
    $guide = Cache::remember('guide_' . $id, 600, function () use ($id) {
        return TourGuide::findOrFail($id);
    });

    return response()->json($guide);
}

//paginated list of all guides
public function getAllPaginated(Request $request)
{
    $page = $request->query('page', 1);

    $guides = Cache::remember('AllGuides_page_' . $page, 600, function () use ($request) {
        return TourGuide::paginate($request->query('per_page', 10));
    });

    return response()->json($guides);
}

//update a guide's info
public function update(Request $request, $id)
{
    $guide = TourGuide::findOrFail($id);
    $guide->update($request->all());

    Cache::forget('guide_' . $id);
    Cache::forget('AllGuides_page_1');

    return response()->json($guide);
}

//delete a guide
public function destroy($id)
{
    $guide = TourGuide::findOrFail($id);
    $guide->delete();

    Cache::forget('guide_' . $id);
    Cache::forget('AllGuides_page_1');

    return response()->json(['message' => 'Guide deleted successfully']);
}

//approve or reject a guide
public function updateApprovalStatus(Request $request)
{
    $guide = TourGuide::findOrFail($request->guide_id);
    $guide->update(['is_approved' => $request->is_approved]);

    Cache::forget('guide_' . $request->guide_id);
    Cache::forget('AllGuides_page_1');
    Cache::forget('approved_guides_count');
    Cache::forget('pending_guides_count');

    return response()->json($guide);
}

}