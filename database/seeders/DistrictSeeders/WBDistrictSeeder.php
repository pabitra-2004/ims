<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class WBDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [664, 'Alipurduar', null, 'APD'],
            [305, 'Bankura', 'BANKURA', 'BNR'],
            [307, 'Birbhum', 'BIRBHUM', 'BIR'],
            [308, 'Cooch Behar', 'COOCH BEHAR', 'CBH'],
            [310, 'Dakshin Dinajpur', 'DAKSHIN DINAJPUR', 'DPD'],
            [309, 'Darjeeling', 'DARJEELING', 'DRJ'],
            [312, 'Hooghly', 'HOOGHLY', 'HOO'],
            [313, 'Howrah', 'HOWRAH', 'HWR'],
            [314, 'Jalpaiguri', 'JALPAIGURI', 'JLP'],
            [703, 'Jhargram', 'Jhargram', 'GRM'],
            [702, 'Kalimpong', 'KALIMPONG', 'MPN'],
            [315, 'Kolkata', 'KOLKATA', 'KLK'],
            [316, 'Malda', 'MALDA', 'MLD'],
            [319, 'Murshidabad', 'MURSHIDABAD', 'MRS'],
            [320, 'Nadia', 'NADIA', 'NAD'],
            [303, 'North 24 Parganas', 'NORTH TWENTY FOUR PARGANAS', 'S24'],
            [704, 'Paschim Bardhaman', 'PASCHIM BARDHAMAN', 'MBR'],
            [318, 'Paschim Medinipur', 'PASCHIM MEDINIPUR', 'MPW'],
            [306, 'Purba Bardhaman', 'PURBA BARDHAMAN', 'BRD'],
            [317, 'Purba Medinipur', 'PURBA MEDINIPUR', 'MPE'],
            [321, 'Purulia', 'PURULIA', 'PRL'],
            [304, 'South 24 Parganas', 'SOUTH 24 Parganas', 'N24'],
            [311, 'Uttar Dinajpur', 'UTTAR DINAJPUR', 'DPU'],
        ];

        $data = array_map(function ($item) {
            return [

                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'West Bengal')->first()->districts()->createMany($data);
    }
}
