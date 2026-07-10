<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Request extends Model
{
    use HasFactory;
    protected $fillable = [
        'is_approved',
        'destination',
        'status',
        'preferred_language',
        'plan',
        'arrival_time',
        'departure_time',
        'Tourist_id',
        'Tour_Guide_id',
    ];
    protected $guarded =[
        'id',
];
    public function tourist()
    {
        return $this->belongsTo(Tourist::class, 'Tourist_id');
    }

    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'Tour_Guide_id');
    }
        public function review(){
        return $this->HasOne(Review::class, 'Request_id');
    }
   
}
