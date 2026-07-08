<?php

namespace Database\Seeders;
use App\Models\Tourist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TouristSeeder extends Seeder
{
    
    public function run(): void
    {
        Tourist::factory(10)->create();
    }
}
