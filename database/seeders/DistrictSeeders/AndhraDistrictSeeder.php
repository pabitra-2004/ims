<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class AndhraDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [745, 'Alluri Sitharama Raju', 'Alluri Sitharama Raju', 'LLR'],
            [744, 'Anakapalli', 'Anakapalli', 'NKP'],
            [502, 'Ananthapuramu', 'అనంతపురము', 'ANT'],
            [753, 'Annamayya', 'Annamayya', 'NNM'],
            [750, 'Bapatla', 'Bapatla', 'BPT'],
            [503, 'Chittoor', 'CHITTOOR', 'CHI'],
            [747, 'Dr. B.R. Ambedkar Konaseema', 'డా బి ఆర్  అంబేడ్కర్ కోనసీమ', 'KNS'],
            [505, 'East Godavari', 'EAST GODAVARI', 'EGI'],
            [748, 'Eluru', 'Eluru', 'LR'],
            [506, 'Guntur', 'GUNTUR', 'GNT'],
            [746, 'Kakinada', 'Kakinada', 'KKN'],
            [510, 'Krishna', 'KRISHNA', 'KRS'],
            [511, 'Kurnool', 'KURNOOL', 'KUR'],
            [790, 'Markapuram', 'Markapuram', ''],
            [755, 'Nandyal', 'Nandyal', 'NND'],
            [749, 'Ntr', 'NTR', 'TNR'],
            [751, 'Palnadu', 'Palnadu', 'PLN'],
            [743, 'Parvathipuram Manyam', 'Parvathipuram Manyam', 'PRV'],
            [791, 'Polavaram', 'Polavaram', ''],
            [517, 'Prakasam', 'PRAKASAM', 'PRA'],
            [519, 'Srikakulam', 'SRIKAKULAM', 'SRK'],
            [515, 'Sri Potti Sriramulu Nellore', 'శ్రీ పొట్టి శ్రీరాములు నెల్లూరు', 'NEL'],
            [754, 'Sri Sathya Sai', 'Sri Sathya Sai', 'SSS'],
            [752, 'Tirupati', 'Tirupati', 'TPT'],
            [520, 'Visakhapatnam', 'విశాఖపట్నం', 'VSK'],
            [521, 'Vizianagaram', 'VIZIANAGARAM', 'VNG'],
            [523, 'West Godavari', 'పశ్చిమగోదావరి', 'WGI'],
            [504, 'Y.S.R. Kadapa', 'వై.ఎస్.ఆర్. కడప', 'CUD'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Andhra Pradesh')->first()->districts()->createMany($data);
    }
}
