<?php

namespace Database\Seeders;

use App\Models\TourGuide;
use App\Models\TourGuideLanguage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TourGuideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = ['English', 'Arabic', 'French', 'German', 'Spanish', 'Italian', 'Russian', 'Chinese', 'Japanese', 'Korean'];
        TourGuide::factory(10)->create()->each(function (TourGuide $guide) use ($languages) {
            $count = fake()->numberBetween(1, 3);
            $picked = fake()->randomElements($languages, $count);

            foreach ($picked as $language) {
                TourGuideLanguage::create([
                    'Tour_Guide_id' => $guide->id,
                    'language' => $language,
                ]);
            }
        });
    }
}
