<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TrackSeeder::class,
            SessionSeeder::class,
            MenuSeeder::class,
            NewsSeeder::class,
            PartnerSeeder::class,
            ServiceSeeder::class,
            SponsorSeeder::class,
        ]);
    }
}
