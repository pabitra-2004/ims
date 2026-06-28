<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class KeralaDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [554, 'Alappuzha', 'ആലപ്പുഴ', 'ALZ'],
            [555, 'Ernakulam', 'എറണാകുളം', 'ERN'],
            [556, 'Idukki', 'ഇടുക്കി', 'IDK'],
            [557, 'Kannur', 'കണ്ണൂർ', 'KNU'],
            [558, 'Kasaragod', 'കാസർഗോഡ്', 'KSR'],
            [559, 'Kollam', 'കൊല്ലം', 'KLM'],
            [560, 'Kottayam', 'കോട്ടയം', 'KTM'],
            [561, 'Kozhikode', 'കോഴിക്കോട്', 'KOZ'],
            [562, 'Malappuram', 'മലപ്പുറം', 'MLP'],
            [563, 'Palakkad', 'പാലക്കാട്', 'PLK'],
            [564, 'Pathanamthitta', 'പത്തനംതിട്ട', 'PTT'],
            [565, 'Thiruvananthapuram', 'തിരുവനന്തപുരം', 'TVP'],
            [566, 'Thrissur', 'തൃശ്ശൂർ', 'TSR'],
            [567, 'Wayanad', 'വയനാട്', 'WAY'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::whereName('Kerala')->first()->districts()->createMany($data);
    }
}
