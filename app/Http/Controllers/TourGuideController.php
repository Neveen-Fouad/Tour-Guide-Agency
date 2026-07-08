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
    $guides = TourGuide::whereHas('languages', function ($query) use ($language) {
        $query->where('language', 'like', '%' . $language . '%');
    })->get();

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

}
