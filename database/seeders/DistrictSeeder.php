<?php

namespace Database\Seeders;

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
        ]);
    }
}
