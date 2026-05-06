<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class AndamanDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [603, 'Nicobars', 'NICOBARS', 'NIC'],
            [632, 'North And Middle Andaman', 'NORTH AND MIDDLE ANDAMAN', 'NMA'],
            [602, 'South Andamans', 'SOUTH ANDAMANS', 'SAS'],
        ];

        $data = array_map(function ($item) {
            return [

                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Andaman And Nicobar Islands')->first()->districts()->createMany($data);
    }
}
