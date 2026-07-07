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
}
