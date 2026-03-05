<?php

declare(strict_types=1);

namespace Modules\Reference\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Reference\Models\State;

class ZzStatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'ddsa_code' => '01',
                'name'      => 'JOHOR',
                'fullname'  => 'Johor',
                'iso_code'  => 'MY-01',
                'sort'      => '1',
            ],
            [
                'ddsa_code' => '02',
                'name'      => 'KEDAH',
                'fullname'  => 'Kedah',
                'iso_code'  => 'MY-02',
                'sort'      => '2',
            ],
            [
                'ddsa_code' => '03',
                'name'      => 'KELANTAN',
                'fullname'  => 'Kelantan',
                'iso_code'  => 'MY-03',
                'sort'      => '3',
            ],
            [
                'ddsa_code' => '04',
                'name'      => 'MELAKA',
                'fullname'  => 'Melaka',
                'iso_code'  => 'MY-04',
                'sort'      => '4',
            ],
            [
                'ddsa_code' => '05',
                'name'      => 'NEGERI SEMBILAN',
                'fullname'  => 'Negeri Sembilan',
                'iso_code'  => 'MY-05',
                'sort'      => '5',
            ],
            [
                'ddsa_code' => '06',
                'name'      => 'PAHANG',
                'fullname'  => 'Pahang',
                'iso_code'  => 'MY-06',
                'sort'      => '6',
            ],
            [
                'ddsa_code' => '07',
                'name'      => 'PULAU PINANG',
                'fullname'  => 'Pulau Pinang',
                'iso_code'  => 'MY-09',
                'sort'      => '7',
            ],
            [
                'ddsa_code' => '08',
                'name'      => 'PERAK',
                'fullname'  => 'Perak',
                'iso_code'  => 'MY-07',
                'sort'      => '8',
            ],
            [
                'ddsa_code' => '09',
                'name'      => 'PERLIS',
                'fullname'  => 'Perlis',
                'iso_code'  => 'MY-08',
                'sort'      => '9',
            ],
            [
                'ddsa_code' => '10',
                'name'      => 'SELANGOR',
                'fullname'  => 'Selangor',
                'iso_code'  => 'MY-12',
                'sort'      => '10',
            ],
            [
                'ddsa_code' => '11',
                'name'      => 'TERENGGANU',
                'fullname'  => 'Terengganu',
                'iso_code'  => 'MY-13',
                'sort'      => '11',
            ],
            [
                'ddsa_code' => '12',
                'name'      => 'SABAH',
                'fullname'  => 'Sabah',
                'iso_code'  => 'MY-10',
                'sort'      => '12',
            ],
            [
                'ddsa_code' => '13',
                'name'      => 'SARAWAK',
                'fullname'  => 'Sarawak',
                'iso_code'  => 'MY-11',
                'sort'      => '13',
            ],
            [
                'ddsa_code' => '14',
                'name'      => 'W. PERSEKUTUAN (KL)',
                'fullname'  => 'W. Persekutuan (Kuala Lumpur)',
                'iso_code'  => 'MY-14',
                'sort'      => '14',
            ],
            [
                'ddsa_code' => '15',
                'name'      => 'W. PERSEKUTUAN (LABUAN)',
                'fullname'  => 'W. Persekutuan (Labuan)',
                'iso_code'  => 'MY-15',
                'sort'      => '15',
            ],
            [
                'ddsa_code' => '16',
                'name'      => 'W. PERSEKUTUAN (PUTRAJAYA)',
                'fullname'  => 'W. Persekutuan (Putrajaya)',
                'iso_code'  => 'MY-16',
                'sort'      => '16',
            ],
            [
                'ddsa_code' => '99',
                'name'      => 'LUAR NEGARA',
                'fullname'  => 'Luar Negara',
                'sort'      => '17',
            ],
            [
                'ddsa_code' => '00',
                'name'      => 'TIADA MAKLUMAT',
                'fullname'  => 'Tiada Maklumat',
                'sort'      => '18',
            ],
            [
                'ddsa_code' => '98',
                'name'      => 'MALAYSIA',
                'fullname'  => 'Malaysia',
                'sort'      => '19',
            ],
            [
                'ddsa_code' => '97',
                'name'      => 'KEBANGSAAN',
                'fullname'  => 'Kebangsaan',
                'sort'      => '20',
            ],
        ];

        foreach ( $data as $datum ) {
            // dd($datum);
            State::firstOrCreate( $datum );
        }
    }
}
