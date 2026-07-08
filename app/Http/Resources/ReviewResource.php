<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
        'id' => $this->id,
        'rating' => $this->rating,
        'comment' => $this->comment,
        'tourist_name' => $this->tourist->name, 
        'tourist_image' => $this->tourist->image,
        'tour_guide_name' => $this->tourGuide->name,
        ];
    }
}
