<?php

namespace Database\Seeders;

use Database\Seeders\DistrictSeeders\AndamanDistrictSeeder;
use Database\Seeders\DistrictSeeders\AndhraDistrictSeeder;
use Database\Seeders\DistrictSeeders\ArunachalDistrictSeeder;
use Database\Seeders\DistrictSeeders\AssamDistrictSeeder;
use Database\Seeders\DistrictSeeders\BiharDistrictSeeder;
use Database\Seeders\DistrictSeeders\ChandigarhDistrictSeeder;
use Database\Seeders\DistrictSeeders\ChhattisgarhDistrictSeeder;
use Database\Seeders\DistrictSeeders\DelhiDistrictSeeder;
use Database\Seeders\DistrictSeeders\GoaDistrictSeeder;
use Database\Seeders\DistrictSeeders\HimachalPradeshDistrictSeeder;
use Database\Seeders\DistrictSeeders\KeralaDistrictSeeder;
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
            ChandigarhDistrictSeeder::class,
            ChhattisgarhDistrictSeeder::class,
            DelhiDistrictSeeder::class,
            GoaDistrictSeeder::class,
            HimachalPradeshDistrictSeeder::class,
            KeralaDistrictSeeder::class,
        ]);
    }
}