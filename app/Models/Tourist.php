<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class Tourist extends Authenticatable implements JWTSubject, CanResetPasswordContract
{
    use HasFactory, Notifiable,CanResetPassword;

    protected $table = 'tourists';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'age',
        'gender',
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
public function requests(){
    return $this->hasMany(Request::class, 'Tourist_id');
}
 

 public function reviews(){
        return $this->hasMany(Review::class, 'Tourist_id');
        }
}
