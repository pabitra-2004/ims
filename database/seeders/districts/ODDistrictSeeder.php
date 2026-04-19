<?php

namespace Database\Seeders\Districts;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\State;
use Illuminate\Database\Seeder;

class ODDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [344, 'Angul', 'ଅନୁଗୋଳ', 'ANU'],
            [345, 'Balangir', 'BALANGIR', 'BLN'],
            [346, 'Balasore', 'ବାଲେଶ୍ୱର', 'BLW'],
            [347, 'Bargarh', 'BARGARH', 'BRG'],
            [348, 'Bhadrak', 'BHADRAK', 'BDK'],
            [349, 'Boudh', 'BOUDH', 'BDH'],
            [350, 'Cuttack', 'CUTTACK', 'CTT'],
            [351, 'Deogarh', 'DEOGARH', 'DGR'],
            [352, 'Dhenkanal', 'DHENKANAL', 'DHK'],
            [353, 'Gajapati', 'GAJAPATI', 'GJP'],
            [354, 'Ganjam', 'GANJAM', 'GNJ'],
            [355, 'Jagatsinghapur', 'JAGATSINGHAPUR', 'JGT'],
            [356, 'Jajpur', 'ଯାଜପୁର', 'JJP'],
            [357, 'Jharsuguda', 'JHARSUGUDA', 'JHR'],
            [358, 'Kalahandi', 'KALAHANDI', 'KLH'],
            [359, 'Kandhamal', 'KANDHAMAL', 'KNM'],
            [360, 'Kendrapara', 'KENDRAPARA', 'KND'],
            [361, 'Keonjhar', 'Kendujhar', 'KNH'],
            [362, 'Khordha', 'KHORDHA', 'KHD'],
            [363, 'Koraput', 'KORAPUT', 'KRP'],
            [364, 'Malkangiri', 'MALKANGIRI', 'MLK'],
            [365, 'Mayurbhanj', 'MAYURBHANJ', 'MYR'],
            [366, 'Nabarangpur', 'NABARANGPUR', 'NBR'],
            [367, 'Nayagarh', 'NAYAGARH', 'NYG'],
            [368, 'Nuapada', 'NUAPADA', 'NPD'],
            [369, 'Puri', 'PURI', 'PUR'],
            [370, 'Rayagada', 'RAYAGADA', 'RYG'],
            [371, 'Sambalpur', 'SAMBALPUR', 'SMB'],
            [372, 'Sonepur', 'SONEPUR', 'SNE'],
            [373, 'Sundargarh', 'SUNDARGARH', 'SDG'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Odisha')->first()->districts()->createMany($data);
    }
}
