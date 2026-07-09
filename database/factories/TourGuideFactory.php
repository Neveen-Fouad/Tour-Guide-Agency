<?php

namespace Database\Factories;

use App\Models\TourGuide;
use Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourGuide>
 */
class TourGuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'phone' => fake()->phoneNumber(),
            'age' => fake()->numberBetween(18, 60),
            'gender' => fake()->randomElement(['male', 'female']),
            'area' => fake()->city(),
            'price_per_hour' => fake()->randomFloat(2, 10, 100),
            'licence' => 'licences/placeholder.jpg',
            'image' => 'guide_pics/placeholder.jpg',
            'is_approved' => fake()->boolean(70),
        ];
    }
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => true,
        ]);
    }
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => false,
        ]);
    }
}
