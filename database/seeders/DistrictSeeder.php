<?php

namespace Database\Seeders;

use Database\Seeders\DistrictSeeders\AndamanDistrictSeeder;
use Database\Seeders\DistrictSeeders\AndhraDistrictSeeder;
use Database\Seeders\DistrictSeeders\ArunachalDistrictSeeder;
use Database\Seeders\DistrictSeeders\AssamDistrictSeeder;
use Database\Seeders\DistrictSeeders\BiharDistrictSeeder;
use Database\Seeders\DistrictSeeders\ODDistrictSeeder;
use Database\Seeders\DistrictSeeders\WBDistrictSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DistrictSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            WBDistrictSeeder::class,
            ODDistrictSeeder::class,
            AndamanDistrictSeeder::class,
            AndhraDistrictSeeder::class,
            ArunachalDistrictSeeder::class,
            AssamDistrictSeeder::class,
            BiharDistrictSeeder::class,
        ]);
    }
}