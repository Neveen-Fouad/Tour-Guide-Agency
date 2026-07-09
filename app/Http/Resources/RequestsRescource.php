<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestsRescource extends JsonResource
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
        'destination' => $this->destination,
        'arival_time' => $this->arival_time,
        'departure_time' => $this->departure_time,
        'status' => $this->status,
        'tourist_name' => $this->tourist->name, 
        'tourist_image' => $this->tourist->image,
        'plan' => $this->plan
        ];
    }
}
