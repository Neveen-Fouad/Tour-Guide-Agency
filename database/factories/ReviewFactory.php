<?php

namespace Database\Factories;

use App\Models\Request;
use App\Models\Review;
use App\Models\Tourist;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


 public function definition(): array
    {
        return [
            'rating' => fake()->numberBetween(1, 5), 
            'comment' => fake()->sentence(), 
            'Tourist_id' => Tourist::inRandomOrder()->first()->id,
            'Request_id' => Request::inRandomOrder()->first()->id,
        ];
    }
}
