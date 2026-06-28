<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class HimachalPradeshDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [15, 'Bilaspur', 'Bilaspur', 'BLS'],
            [16, 'Chamba', 'Chamba', 'CHM'],
            [17, 'Hamirpur', 'Hamirpur', 'HMP'],
            [18, 'Kangra', 'Kangra', 'KNG'],
            [19, 'Kinnaur', 'Kinnaur', 'KIN'],
            [20, 'Kullu', 'Kullu', 'KUL'],
            [21, 'Lahaul And Spiti', 'Lahaul and Spiti', 'LAS'],
            [22, 'Mandi', 'Mandi', 'MND'],
            [23, 'Shimla', 'Shimla', 'SHM'],
            [24, 'Sirmaur', 'Sirmaur', 'SRM'],
            [25, 'Solan', 'Solan', 'SLN'],
            [26, 'Una', 'Una', 'UNA'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::whereName('Himachal Pradesh')->first()->districts()->createMany($data);
    }
}
