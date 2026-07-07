<?php

namespace App\Http\Controllers;
use App\Models\Tourist;
use App\Models\TourGuide;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{ // tourist sign up
        public function registerTourist(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:tourists,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:20',
                'age' => 'required|integer|min:16|max:120',
                'gender' => 'required|in:male,female'
            ]);
            $user = Tourist::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'age' => $validated['age'],
                'gender' => $validated['gender']
            ]);
            $token = JWTAuth::fromUser($user);

        } catch (Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }

        return response()->json([
            'message' => 'Tourist registered successfully',
            'token' => $token,
            'user' => $user,
            'role' => 'tourist'
        ], 201);
    }
    // tourguide sign up
        public function registerTourGuide(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:50',
                'email' => 'required|email|unique:tour_guides,email',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'required|string|max:20',
                'gender' => 'required|in:male,female',
                'age' => 'required|integer|min:18|max:80',
                'area' => 'nullable|string|max:255',
                'price_per_hour' => 'required|numeric|min:0',
                'licence' => 'required|string',
                'image' => 'nullable|string|max:255',
                'languages' => 'required|array',
                'languages.*' => 'string|max:30'
            ]);
            $user = TourGuide::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['phone'],
                'gender' => $validated['gender'],
                'age' => $validated['age'],
                'area' => $validated['area'] ?? null,
                'price_per_hour' => $validated['price_per_hour'],
                'licence' => $validated['licence'],
                'image' => $validated['image'] ?? null,
                'is_approved' => false
            ]);

            // Add languages if provided
            if (isset($validated['languages']) && is_array($validated['languages'])) {
                foreach ($validated['languages'] as $language) {
                    TourGuideLanguage::create([
                        'Tour_Guide_id' => $user->id,
                        'language' => $language
                    ]);
                }
            }
            $token = JWTAuth::fromUser($user);
        } catch (Exception $e) {
            return response()->json(['exception' => $e->getMessage()]);
        }
        return response()->json([
            'message' => 'Tour guide registered successfully',
            'token' => $token,
            'user' => $user,
            'role' => 'tour_guide',
            'is_approved' => false
        ], 201);
    }
    public function login(Request $request){
            $credentials = $request->only('email', 'password');
        // tourist login
        $user = Tourist::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
        $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
            'role' => 'tourist'
        ]);}
        // tourguide login
        $user = TourGuide::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            if (!$user->is_approved) {
            return response()->json([
                'message' => 'Your account is pending approval'
            ], 403);}
            $token = JWTAuth::fromUser($user);
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user,
            'role' => 'tour_guide',
            'is_approved' => $user->is_approved
        ]);}
        return response()->json([
        'message' => 'Invalid credentials'
        ], 401);
    }
    // tourist & tourguide logout
    public function logout(){
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json([
            'message' => 'User logged out successfully'
        ]);}
    // refresh token
    public function refresh(){
        $token = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            'token' => $token
        ]);
    }
    // my profile
    public function me(){
    $user = auth()->user();
    // validation
    if (!$user) {
        return response()->json([
            'message' => 'User not found or token invalid'
        ], 404);
    }
    // checking user role
    if ($user instanceof Tourist) {
        $role = 'Tourist';
    } elseif ($user instanceof TourGuide) {
        $role = 'TourGuide';
    }
    return response()->json([
        'message' => 'User profile',
        'data' => $user,
        'role' => $role
    ]);
}
}

