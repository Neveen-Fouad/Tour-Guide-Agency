<?php

namespace Database\Factories;

use App\Models\TourGuide;
use App\Models\TourGuideLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TourGuideLanguage>
 */
class TourGuideLanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Tour_Guide_id' => TourGuide::factory(),
            'language' => fake()->randomElement([
                'English', 'Arabic', 'French', 'German', 'Spanish', 'Italian', 'Russian', 'Chinese', 'Japanese', 'Korean'
            ]),
        ];
    }
}
