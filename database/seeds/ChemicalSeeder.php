<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChemicalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'Arsenic',
                'formula' => 'As (III)',
                'oralR' => 1.5,
                'oralS' => 0.0003,
            ],
            [
                'id' => 2,
                'name' => 'Arsenic',
                'formula' => 'As (V)',
                'oralR' => 9.5,
                'oralS' => 0.0003,
            ],
            [
                'id' => 3,
                'name' => 'Lead',
                'formula' => 'Pb',
                'oralR' => 0.0085,
                'oralS' => 0,
            ],
            [
                'id' => 4,
                'name' => 'Cadmium',
                'formula' => 'Cd',
                'oralR' => 0,
                'oralS' => 0.0005,
            ],
            [
                'id' => 5,
                'name' => 'Copper',
                'formula' => 'Cu',
                'oralR' => 0,
                'oralS' => 0.038,
            ],
            [
                'id' => 6,
                'name' => 'Antimony',
                'formula' => 'Sb',
                'oralR' => 0,
                'oralS' => 0.0004,
            ],
            [
                'id' => 7,
                'name' => 'Chromium',
                'formula' => 'Cr (III)',
                'oralR' => 0,
                'oralS' => 1.5,
            ],
            [
                'id' => 8,
                'name' => 'Chromium',
                'formula' => 'Cr (IV)',
                'oralR' => 0.5,
                'oralS' => 0.003,
            ],
            [
                'id' => 9,
                'name' => 'Mercury',
                'formula' => 'Hg',
                'oralR' => 0,
                'oralS' => 0.00006,
            ],
            [
                'id' => 10,
                'name' => 'Zinc',
                'formula' => 'Zn',
                'oralR' => 0,
                'oralS' => 0.91,
            ],
            [
                'id' => 11,
                'name' => 'Nickle',
                'formula' => 'Ni',
                'oralR' => 0,
                'oralS' => 0.02,
            ],
            [
                'id' => 12,
                'name' => 'Silver',
                'formula' => 'Ag',
                'oralR' => 0,
                'oralS' => 0.005,
            ],
            [
                'id' => 13,
                'name' => 'Manganese',
                'formula' => 'Mn',
                'oralR' => 0,
                'oralS' => 0.14,
            ],
            [
                'id' => 14,
                'name' => 'Barium',
                'formula' => 'Ba',
                'oralR' => 0,
                'oralS' => 0.2,
            ],
            [
                'id' => 15,
                'name' => 'Caesium',
                'formula' => 'Cs',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 16,
                'name' => 'Tellurium',
                'formula' => 'Te',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 17,
                'name' => 'Tin',
                'formula' => 'Sn',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 18,
                'name' => 'Titanium',
                'formula' => 'Ti',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 19,
                'name' => 'Iron',
                'formula' => 'Fe',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 20,
                'name' => 'Calcium',
                'formula' => 'Ca',
                'oralR' => 0,
                'oralS' => 0,
            ],
            [
                'id' => 21,
                'name' => 'Potassium',
                'formula' => 'K',
                'oralR' => 0,
                'oralS' => 0,
            ],
        ];

        foreach ($data as $chemical) {
            DB::table('chemicals')->insert($chemical);
        }
    }
}
