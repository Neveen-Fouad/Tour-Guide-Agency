<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuide extends Model
{
// Authentication
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
        'price_per_hour', 'age', 'gender', 'language',
        'guide_pic', 'license_pic', 'is_approved',
    ];

    protected $hidden = ['password']; // never return password in API responses

    protected $casts = [
        'is_approved' => 'boolean',
        'price_per_hour' => 'float',
    ];
}
