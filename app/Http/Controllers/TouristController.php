<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTouristsRequest;
use App\Http\Resources\TouristResource;
use App\Models\Tourist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TouristController extends Controller
{
    

    public function index(GetTouristsRequest $request): JsonResponse
    {
        $page    = $request->integer('page', 1);
        $perPage = $request->integer('per_page', 10);
        $search  = $request->string('search', '')->toString();
        $gender  = $request->string('gender', '')->toString();

        
        $cacheKey = 'tourists_' . md5("page={$page}&per_page={$perPage}&search={$search}&gender={$gender}");

        $data = Cache::remember($cacheKey, now()->addMinutes(60), function () use ($perPage, $search, $gender) {
            $query = Tourist::query();

            // Search by name or email
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filter by gender
            if ($gender !== '') {
                $query->where('gender', $gender);
            }

            return $query->paginate($perPage);
        });

        return response()->json([
            'data' => TouristResource::collection($data),
            'meta' => [
                'current_page' => $data->currentPage(),
                'per_page'     => $data->perPage(),
                'total'        => $data->total(),
                'last_page'    => $data->lastPage(),
                'next_page'    => $data->hasMorePages() ? $data->currentPage() + 1 : null,
                'prev_page'    => $data->currentPage() > 1 ? $data->currentPage() - 1 : null,
            ],
        ], 200);
    }

 

    public function show(int $id): JsonResponse
    {
        $tourist = Cache::remember("tourist_{$id}", now()->addMinutes(60), function () use ($id) {
            return Tourist::find($id);
        });

        if (! $tourist) {
            return response()->json([
                'message' => 'Tourist not found.',
            ], 404);
        }

        return response()->json([
            'data' => new TouristResource($tourist),
        ], 200);
    }
}
