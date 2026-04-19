<?php

namespace Database\Seeders;

use Database\Seeders\Districts\ODDistrictSeeder;
use Database\Seeders\Districts\WBDistrictSeeder;
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
