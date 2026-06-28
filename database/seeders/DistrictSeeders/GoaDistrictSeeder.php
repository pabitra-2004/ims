<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class GoaDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [793, 'Kushavati', 'Kushavati', ''],
            [551, 'North Goa', 'NORTH GOA', 'NGO'],
            [552, 'South Goa', 'SOUTH GOA', 'SGO'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::whereName('Goa')->first()->districts()->createMany($data);
    }
}
