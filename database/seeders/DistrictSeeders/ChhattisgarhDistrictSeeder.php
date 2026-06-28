<?php

namespace Database\Seeders\DistrictSeeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class ChhattisgarhDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $districts = [
            [646, 'Balod', 'बालोद', 'BLD'],
            [644, 'Balodabazar-Bhatapara', 'बलौदाबाजार-भाटापारा', 'BLB'],
            [649, 'Balrampur-Ramanujganj', 'बलरामपुर-रामानुजगंज', 'BLM'],
            [374, 'Bastar', 'बस्तर', 'BAS'],
            [650, 'Bemetara', 'बेमेतरा', , 'BEM'],
            [636, 'Bijapur', 'बीजापुर', 'BIJ'],
            [375, 'Bilaspur', 'बिलासपुर', 'BLP'],
            [376, 'Dakshin Bastar Dantewada', 'दक्षिण बस्तर दंतेवाड़ा', 'DNT'],
            [377, 'Dhamtari', 'धमतरी', 'DMT'],
            [378, 'Durg', 'दुर्ग', 'DRG'],
            [645, 'Gariyaband', 'गरियाबंद', 'GRY'],
            [734, 'Gaurela-Pendra-Marwahi', 'गौरेला-पेंड्रा-मरवाही', 'GRL'],
            [379, 'Janjgir-Champa', 'जांजगीर - चाम्पा', 'JCH'],
            [380, 'Jashpur', 'जशपुर', 'JSH'],
            [382, 'Kabeerdham', 'कबीरधाम', 'KDM'],
            [759, 'Khairagarh-Chhuikhadan-Gandai', 'खैरागढ़-छुईखदान-गंडई', 'KCG'],
            [643, 'Kondagaon', 'कोंडागांव', 'KON'],
            [383, 'Korba', 'कोरबा', 'KRB'],
            [384, 'Korea', 'कोरिया', 'KOR'],
            [385, 'Mahasamund', 'महासमुंद', 'MHS'],
            [760, 'Manendragarh-Chirmiri-Bharatpur(M C B)', 'मनेन्द्रगढ़-चिरमिरी-भरतपुर(ऍम.सी.बी.)', 'MNN'],
            [761, 'Mohla-Manpur-Ambagarh Chouki', 'मोहला-मानपुर-अम्बागढ़ चौकी', 'MHL'],
            [647, 'Mungeli', 'मुंगेली', 'MUN'],
            [637, 'Narayanpur', 'नारायणपुर', 'NRY'],
            [386, 'Raigarh', 'रायगढ़', 'RGR'],
            [387, 'Raipur', 'रायपुर', 'RPR'],
            [388, 'Rajnandgaon', 'राजनंदगांव', 'RJN'],
            [762, 'Sakti', 'सक्ती', 'SKT'],
            [763, 'Sarangarh-Bilaigarh', 'सारंगढ़-बिलाईगढ़', 'SRB'],
            [642, 'Sukma', 'सुकमा', 'SKM'],
            [648, 'Surajpur', 'सूरजपुर', 'SRJ'],
            [389, 'Surguja', 'सरगुजा', 'SRG'],
            [381, 'Uttar Bastar Kanker', 'उत्तर बस्तर कांकेर', 'KNK'],
        ];

        $data = array_map(function ($item) {
            return [
                'lgd_code' => $item[0],
                'name' => $item[1],
                'local_name' => $item[2],
                'short_name' => $item[3],
            ];
        }, $districts);

        State::whereName('Chhattisgarh')->first()->districts()->createMany($data);
    }
}
