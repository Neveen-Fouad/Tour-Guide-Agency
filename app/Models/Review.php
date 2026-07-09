<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;
    protected $fillable =[
        'rating',
        'comment'
    ];

    protected $guarded=[
        'id',
        'Tourist_id	',
        'Request_id'
    ];

    public function tourist()
    {
        return $this->belongsTo(Tourist::class,'Tourist_id');
    }

     public function request()
    {
        return $this->belongsTo(Request::class,'Request_id');
    }
   
   use HasFactory;
}
