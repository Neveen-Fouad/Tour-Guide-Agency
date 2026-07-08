<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        Review::factory()->count(15)->create();
    }
}

