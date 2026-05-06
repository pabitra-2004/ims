<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class AssamDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [739, 'Bajali', '', 'BJL'],
            [616, 'Baksa', '', 'BAK'],
            [280, 'Barpeta', 'BARPETA', 'BAR'],
            [705, 'Biswanath', '', 'BSW'],
            [281, 'Bongaigaon', 'BONGAIGAON', 'BNG'],
            [282, 'Cachar', 'CACHAR', 'CCH'],
            [708, 'Charaideo', '', 'CID'],
            [612, 'Chirang', '', 'CRG'],
            [283, 'Darrang', 'DARRANG', 'DRR'],
            [284, 'Dhemaji', 'DHEMAJI', 'DHM'],
            [285, 'Dhubri', 'DHUBURI', 'DHB'],
            [286, 'Dibrugarh', 'DIBRUGARH', 'DBR'],
            [299, 'Dima Hasao', 'DIMA HASAO', 'DHO'],
            [287, 'Goalpara', 'GOALPARA', 'GLP'],
            [288, 'Golaghat', 'GOLAGHAT', 'GLG'],
            [289, 'Hailakandi', 'HAILAKANDI', 'HLK'],
            [709, 'Hojai', '', 'HJ'],
            [290, 'Jorhat', 'JORHAT', 'JRH'],
            [291, 'Kamrup', 'KAMRUP', 'KMP'],
            [618, 'Kamrup Metro', 'KAMRUP MOHANAGAR', 'KMT'],
            [292, 'Karbi Anglong', 'KARBI ANGLONG', 'KAG'],
            [294, 'Kokrajhar', 'KOKRAJHAR', 'KKR'],
            [295, 'Lakhimpur', 'LAKHIMPUR', 'LKP'],
            [706, 'Majuli', '', 'MJL'],
            [296, 'Marigaon', 'MARIGAON', 'MGN'],
            [297, 'Nagaon', 'NAGAON', 'NGN'],
            [298, 'Nalbari', 'NALBARI', 'NLB'],
            [300, 'Sivasagar', 'SIVASAGAR', 'SVS'],
            [301, 'Sonitpur', 'SONITPUR', 'SON'],
            [707, 'South Salmara Mancachar', '', 'STH'],
            [293, 'Sribhumi', 'শ্ৰীভূমি', 'KGJ'],
            [756, 'Tamulpur', '', 'TML'],
            [302, 'Tinsukia', 'TINSUKIA', 'TIN'],
            [617, 'Udalguri', '', 'UDA'],
            [710, 'West Karbi Anglong', '', 'WST'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Assam')->first()->districts()->createMany($data);
    }
}
