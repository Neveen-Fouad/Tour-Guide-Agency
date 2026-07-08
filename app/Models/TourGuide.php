<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\TourGuideLanguage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

class TourGuide extends Model implements JWTSubject, CanResetPasswordContract
{
// Authentication
use Notifiable, CanResetPassword;
public function getJWTIdentifier()
{
    return $this->getKey();
}
public function getJWTCustomClaims()
{
    return [
        'role' => 'TourGuide',
        'is_approved' => $this->is_approved,
    ];
}
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'area',
        'price_per_hour', 'age', 'gender',
        'image', 'licence', 'is_approved',
    ];

    protected $hidden = ['password']; // never return password in API responses

    protected $casts = [
        'is_approved' => 'boolean',
        'price_per_hour' => 'float',
    ];
    public function languages()
{
    return $this->hasMany(TourGuideLanguage::class, 'Tour_Guide_id');
}

public function reviews()
{
    return $this->hasManyThrough(Review::class, Request::class);
}

    
}
