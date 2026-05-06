<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class ArunachalDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [628, 'Anjaw', '', 'ANJ'],
            [787, 'Bichom', 'Bichom', ''],
            [229, 'Changlang', 'CHANGLANG', 'CHG'],
            [230, 'Dibang Valley', 'DIBANG VALLEY', 'DBN'],
            [231, 'East Kameng', 'EAST KAMENG', 'EKG'],
            [232, 'East Siang', 'EAST SIANG', 'ESG'],
            [718, 'Kamle', 'KAMLE', 'KML'],
            [786, 'Keyi Panyor', 'Keyi Panyor', ''],
            [677, 'Kra Daadi', 'KRA DAADI', 'KRD'],
            [233, 'Kurung Kumey', 'KURUNG KUMEY', 'KKY'],
            [724, 'Leparada', 'LEPARADA', 'LPR'],
            [234, 'Lohit', 'LOHIT', 'LHT'],
            [666, 'Longding', 'LONGDING', 'LDG'],
            [235, 'Lower Dibang Valley', 'LOWER DIBANG VALLEY', 'LDV'],
            [719, 'Lower Siang', 'LOWER SIANG', 'LWR'],
            [236, 'Lower Subansiri', 'LOWER SUBANSIRI', 'LSI'],
            [678, 'Namsai', '', 'NMS'],
            [723, 'Pakke Kessang', 'PAKKE KESSANG', 'PKK'],
            [237, 'Papum Pare', 'PAPUM PARE', 'PPM'],
            [725, 'Shi Yomi', 'SHI YOMI', 'SHY'],
            [679, 'Siang', '', 'SAN'],
            [238, 'Tawang', 'TAWANG', 'TWN'],
            [239, 'Tirap', 'TIRAP', 'TRP'],
            [240, 'Upper Siang', 'UPPER SIANG', 'USG'],
            [241, 'Upper Subansiri', 'UPPER SUBANSIRI', 'USI'],
            [242, 'West Kameng', 'WEST KAMENG', 'WKG'],
            [243, 'West Siang', 'WEST SIANG', 'WS'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Arunachal Pradesh')->first()->districts()->createMany($data);
    }
}
