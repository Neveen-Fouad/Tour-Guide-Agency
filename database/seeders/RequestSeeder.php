<?php

namespace Database\Seeders;

use App\Models\Request;
use App\Models\TourGuide;
use App\Models\Tourist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $touristIds = Tourist::pluck('id');
        $guideIds = TourGuide::pluck('id');

        if ($touristIds->isEmpty() || $guideIds->isEmpty()) {
            $this->command->warn('No tourists or guides found - skipping RequestSeeder. Seed TouristSeeder and TourGuideSeeder first.');
            return;
        }

        collect(range(1, 20))->each(function () use ($touristIds, $guideIds) {
            $request = Request::factory()->make();
            $request->Tourist_id = $touristIds->random();
            $request->Tour_Guide_id = $guideIds->random();
            $request->save();
        });
    }
}
