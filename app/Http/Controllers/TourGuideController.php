<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TourGuideController extends Controller
{
    public function show($id)
    {
        $guide = TourGuide::findOrFail($id);
        return response()->json($guide);
    }
}
