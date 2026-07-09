<?php

namespace Database\Factories;

use App\Models\Request;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $arrival = fake()->dateTimeBetween('now', '+2 months');
        $departure = (clone $arrival)->modify('+' . fake()->numberBetween(1, 10) . ' days');
        return [
            'is_approved' => fake()->boolean(60),
            'destination' => fake()->city(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected', 'completed']),
            'preferred_language' => fake()->randomElement(['English', 'Arabic', 'French', 'German', 'Spanish']),
            'plan' => fake()->paragraph(),
            'arrival_time' => $arrival,
            'departure_time' => $departure,
        ];
    }
}
