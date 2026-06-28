<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class DelhiDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [77, 'Central', 'CENTRAL', 'CNT'],
            [796, 'Central North', 'Central North', ''],
            [78, 'East', 'EAST', 'EST'],
            [79, 'New Delhi', 'NEW DELHI', 'NDL'],
            [80, 'North', 'NORTH', 'NRD'],
            [81, 'North East', 'NORTH EAST', 'NED'],
            [82, 'North West', 'NORTH WEST', 'NWD'],
            [795, 'Old Delhi', 'Old Delhi', ''],
            [794, 'Outer North', 'Outer North', ''],
            [83, 'South', 'SOUTH', 'SDL'],
            [670, 'South East', 'SOUTH EAST', 'STS'],
            [84, 'South West', 'SOUTH WEST', 'SWD'],
            [85, 'West', 'WEST', 'WSD'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::whereName('Delhi')->first()->districts()->createMany($data);
    }
}
