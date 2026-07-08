<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =[
        'rating',
        'comment'
    ];

    protected $guarded=[
        'id',
        'Tourist_id	',
        'Request_id'
    ];

    public function tourist(): BelongsTo
    {
        return $this->belongsTo(Tourist::class);
    }

     public function request(): BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
   
   
}
