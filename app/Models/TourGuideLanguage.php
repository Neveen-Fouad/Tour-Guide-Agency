<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TourGuideLanguage extends Model
{
    use HasFactory;
    protected $fillable = ['Tour_Guide_id', 'language'];
    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'Tour_Guide_id');
    }
}