<?php

namespace App\Http\Controllers;
use App\Models\Tourist;
use App\Models\TourGuide;
use App\Models\TourGuideLanguage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Password;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{ // tourist sign up
        public function registerTourist(Request $request)
    {
        try {
            $validated = $request->validate([
                'TouristName' => 'required|string|max:50',
                'TouristEmail' => ['required', 'email', 'unique:tourists,email',
                    function ($attribute, $value, $fail) {
                        if (TourGuide::where('email', $value)->exists()) {
                            $fail('This email is already registered as a tour guide.');}}],
                'TouristPassword' => 'required|string|min:8|confirmed',
                'TouristPhone' => 'required|string|max:20',
                'TouristAge' => 'required|integer|min:16|max:120',
                'TouristGender' => 'required|in:male,female'
            ]);
            $user = Tourist::create([
                'name' => $validated['TouristName'],
                'email' => $validated['TouristEmail'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['TouristPhone'],
                'age' => $validated['TouristAge'],
                'gender' => $validated['TouristGender']
            ]);
            $token = JWTAuth::fromUser($user);

        } catch (Exception $e) {
            return response()->json(['exception' => $e->getMessage()],500);
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
                'GuideName' => 'required|string|max:50',
                'GuideEmail' => ['required', 'email', 'unique:tour_guides,email',
                    function ($attribute, $value, $fail) {
                        if (Tourist::where('email', $value)->exists()) {
                            $fail('This email is already registered as a tourist.');}}],
                'GuidePassword' => 'required|string|min:8|confirmed',
                'GuidePhone' => 'required|string|max:20',
                'GuideGender' => 'required|in:male,female',
                'GuideAge' => 'required|integer|min:18|max:80',
                'GuideArea' => 'nullable|string|max:255',
                'GuidePricePerHour' => 'required|numeric|min:0',
                'Licence_pic' => 'required|image|max:5120',
                'guide_pic' => 'nullable|image|max:5120',
                'GuideLanguages' => 'required|string',
                'GuideLanguages.*' => 'string|max:30'
            ]);
            $licencePath = $request->file('Licence_pic')->store('licences', 'public');
            $guidePicPath = $request->hasFile('guide_pic')
            ? $request->file('guide_pic')->store('guide_pics', 'public')
            : null;
            $user = TourGuide::create([
                'name' => $validated['GuideName'],
                'email' => $validated['GuideEmail'],
                'password' => Hash::make($validated['password']),
                'phone' => $validated['GuidePhone'],
                'gender' => $validated['GuideGender'],
                'age' => $validated['GuideAge'],
                'area' => $validated['GuideArea'] ?? null,
                'price_per_hour' => $validated['GuidePricePerHour'],
                'licence' => $licencePath,
                'image' => $guidePicPath,
                'is_approved' => false
        ]);

            // Add languages if provided
            if (isset($validated['GuideLanguages']) && is_array($validated['GuideLanguages'])) {
            foreach ($validated['GuideLanguages'] as $language) {
                TourGuideLanguage::create([
                    'Tour_Guide_id' => $user->id,
                    'language' => $language
                ]);
            }
        }
            $token = JWTAuth::fromUser($user);
        } catch (Exception $e) {
            return response()->json(['exception' => $e->getMessage()],500);
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
    $payload = auth()->payload();
    $role = $payload->get('role');
    $id = $payload->get('sub');

    $user = $role === 'Tourist'
        ? Tourist::find($id)
        : TourGuide::find($id);
    if (!$user) {
        return response()->json([
            'message' => 'User not found or token invalid'
        ], 404);
    }
    return response()->json([
        'message' => 'User profile',
        'data' => $user,
        'role' => $role
    ]);
}
//forget pass
public function forgetPassword(Request $request){
 $request->validate([
    'email'=>['required','email',
            function ($attribute, $value, $fail) {
            $exists = Tourist::where('email', $value)->exists() || 
                      TourGuide::where('email', $value)->exists();
            if (!$exists) {
                $fail('The email does not exist in our records.');
            }}]
 ]);
 //generate reset link & send via email
 $broker = Tourist::where('email', $request->email)->exists()
 ?'tourists' 
 :'tour_guides';
 $status=Password::broker($broker)->sendResetLink(
    $request->only('email')
 );
// 
if ($status==Password::RESET_LINK_SENT) {
    return response()->json(["message"=>$status]);
 }
 return response()->json(["message"=> $status],422);
}
//reset pass (changes pass)
public function resetPassword(Request $request){
    $request->validate([
        'email'=>'required|email',
        'token'=>'required',
        'password'=> 'required|confirmed|min:8'
    ]);
     $broker = Tourist::where('email', $request->email)->exists()
    ?'tourists' 
    :'tour_guides';
    // changing pass
    $status=Password::broker($broker)->reset(
        $request->only('email','token','password','password_confirmation'),
        function($user,string $password){
        $user->update(['password'=>Hash::make($password)]);
    });
    return response()->json([
        'message'=> $status
    ],$status===Password::PASSWORD_RESET ?200 :422);
}

}

