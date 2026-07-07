<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Tourist extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'tourists';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'age',
        'gender',
        'profile_picture',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'age'      => 'integer',
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::saved(function (Tourist $tourist) {
            Cache::forget("tourist_{$tourist->id}");
            Cache::forget('tourists_count');
        });

        static::deleted(function (Tourist $tourist) {
            Cache::forget("tourist_{$tourist->id}");
            Cache::forget('tourists_count');
        });
    }

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'role' => 'Tourist',
        ];
    }
}
