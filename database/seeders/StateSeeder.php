<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\Clock\now;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            [35, 'Andaman And Nicobar Islands', 'ANDAMAN AND NICOBAR ISLANDS', 'UT'],
            [28, 'Andhra Pradesh', 'ANDHRA PRADESH', 'State'],
            [12, 'Arunachal Pradesh', 'ARUNACHAL PRADESH', 'State'],
            [18, 'Assam', 'ASSAM', 'State'],
            [10, 'Bihar', 'BIHAR', 'State'],
            [4, 'Chandigarh', 'CHANDIGARH', 'UT'],
            [22, 'Chhattisgarh', "छत्तीसगढ़", 'State'],
            [7, 'Delhi', 'DELHI', 'UT'],
            [30, 'Goa', 'GOA', 'State'],
            [24, 'Gujarat', 'GUJARAT', 'State'],
            [6, 'Haryana', 'HARYANA', 'State'],
            [2, 'Himachal Pradesh', 'HIMACHAL PRADESH', 'State'],
            [1, 'Jammu And Kashmir', 'JAMMU AND KASHMIR', 'UT'],
            [20, 'Jharkhand', "झारखंड", 'State'],
            [29, 'Karnataka', 'ಕರ್ನಾಟಕ', 'State'],
            [32, 'Kerala', 'KERALA', 'State'],
            [37, 'Ladakh', 'Ladakh', 'UT'],
            [31, 'Lakshadweep', 'LAKSHADWEEP', 'UT'],
            [23, 'Madhya Pradesh', 'MADHYA PRADESH', 'State'],
            [27, 'Maharashtra', "महाराष्ट्र", 'State'],
            [14, 'Manipur', 'MANIPUR', 'State'],
            [17, 'Meghalaya', 'MEGHALAYA', 'State'],
            [15, 'Mizoram', 'MIZORAM', 'State'],
            [13, 'Nagaland', 'NAGALAND', 'State'],
            [21, 'Odisha', "ଓଡ଼ିଶା", 'State'],
            [34, 'Puducherry', 'PUDUCHERRY', 'UT'],
            [3, 'Punjab', 'PUNJAB', 'State'],
            [8, 'Rajasthan', 'RAJASTHAN', 'State'],
            [11, 'Sikkim', 'SIKKIM', 'State'],
            [33, 'Tamil Nadu', 'TAMIL NADU', 'State'],
            [36, 'Telangana', "తెలంగాణ", 'State'],
            [38, 'The Dadra And Nagar Haveli And Daman And Diu', 'THE DADRA AND NAGAR HAVELI AND DAMAN AND DIU', 'UT'],
            [16, 'Tripura', "ত্রিপুরা", 'State'],
            [5, 'Uttarakhand', 'UTTARAKHAND', 'State'],
            [9, 'Uttar Pradesh', 'UTTAR PRADESH', 'State'],
            [19, 'West Bengal', 'WEST BENGAL', 'State'],
        ];

        $data = array_map(function ($state) {
            $now = now();

            return [
                'lgd_code' => $state[0],
                'name' => $state[1],
                'local_name' => $state[2],
                'state_ut' => $state[3],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $states);

        DB::table('states')->insert($data);
    }
}
