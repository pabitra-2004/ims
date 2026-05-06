<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class BiharDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [188, 'Araria', 'अररिया', 'ARA'],
            [611, 'Arwal', 'अरवल', 'ARW'],
            [189, 'Aurangabad', 'औरंगाबाद', 'AGB'],
            [190, 'Banka', 'बांका', 'BNK'],
            [191, 'Begusarai', 'बेगूसराय', 'BSR'],
            [192, 'Bhagalpur', 'भागलपुर', 'BGO'],
            [193, 'Bhojpur', 'भोजपुर', 'BJP'],
            [194, 'Buxar', 'बक्सर', 'BUX'],
            [195, 'Darbhanga', 'दरभंगा', 'DBG'],
            [196, 'Gaya', 'गया', 'GAY'],
            [197, 'Gopalganj', 'गोपालगंज', 'GPG'],
            [198, 'Jamui', 'जमुई', 'JAM'],
            [199, 'Jehanabad', 'जहानाबाद', 'JHB'],
            [200, 'Kaimur (Bhabua)', 'कैमूर ( भभुआ )', 'KMR'],
            [201, 'Katihar', 'कटिहार', 'KTR'],
            [202, 'Khagaria', 'खगड़िया', 'KGR'],
            [203, 'Kishanganj', 'किशनगंज', 'KSG'],
            [204, 'Lakhisarai', 'लखीसराय', 'LSR'],
            [205, 'Madhepura', 'मधेपुरा', 'MDP'],
            [206, 'Madhubani', 'मधुबनी', 'MDB'],
            [207, 'Munger', 'मुंगेर', 'MNG'],
            [208, 'Muzaffarpur', 'मुजफ्फरपुर', 'MUZ'],
            [209, 'Nalanda', 'नालंदा', 'NLD'],
            [210, 'Nawada', 'नवादा', 'NAW'],
            [211, 'Pashchim Champaran', 'पश्चिम चम्पारण', 'PSC'],
            [212, 'Patna', 'पटना', 'PTN'],
            [213, 'Purbi Champaran', 'पूर्वी चंपारण', 'PRC'],
            [214, 'Purnia', 'पूर्णिया', 'PRN'],
            [215, 'Rohtas', 'रोहतास', 'RTS'],
            [216, 'Saharsa', 'सहरसा', 'SHS'],
            [217, 'Samastipur', 'समस्तीपुर', 'SMS'],
            [218, 'Saran', 'सारण', 'SAR'],
            [219, 'Sheikhpura', 'शेखपुरा', 'SHK'],
            [220, 'Sheohar', 'शिवहर', 'SHH'],
            [221, 'Sitamarhi', 'सीतामढी', 'STM'],
            [222, 'Siwan', 'सिवान', 'SWN'],
            [223, 'Supaul', 'सुपौल', 'SPL'],
            [224, 'Vaishali', 'वैशाली', 'VSH'],

        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::where('name', 'Bihar')->first()->districts()->createMany($data);
    }
}
