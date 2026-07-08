<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourGuideLanguage extends Model
{
    protected $fillable = ['Tour_Guide_id', 'language'];
    public function tourGuide()
    {
        return $this->belongsTo(TourGuide::class, 'Tour_Guide_id');
    }
}