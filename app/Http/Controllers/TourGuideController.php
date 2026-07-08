<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourGuide;

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
    $guides = TourGuide::where('language', 'like', '%' . $language . '%')->get();
    return response()->json($guides);
}


//Approved Guides Number
public function approvedCount()
{
    $count = TourGuide::where('is_approved', true)->count();

    return response()->json(['No_of_guides' => $count]);
}

//Pending Guides Number
public function pendingCount()
{
    $count = TourGuide::where('is_approved', false)->count();

    return response()->json(['No_of_pending_guides' => $count]);
}

//single guide by id
public function getById($id)
{
    $guide = TourGuide::findOrFail($id);
    return response()->json($guide);
}

//paginated list of all guides
public function getAllPaginated()
{
    $guides = TourGuide::paginate(10);
    return response()->json($guides);
}

//update a guide's info
public function update(Request $request, $id)
{
    $guide = TourGuide::findOrFail($id);
    $guide->update($request->all());
    return response()->json($guide);
}

//delete a guide
public function destroy($id)
{
    $guide = TourGuide::findOrFail($id);
    $guide->delete();
    return response()->json(['message' => 'Guide deleted successfully']);
}

//approve or reject a guide
public function updateApprovalStatus(Request $request)
{
    $guide = TourGuide::findOrFail($request->guide_id);
    $guide->update(['is_approved' => $request->is_approved]);
    return response()->json($guide);
}

}
