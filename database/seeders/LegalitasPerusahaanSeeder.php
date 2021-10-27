<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class LegalitasPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            'Legalitas Perusahaan',
            'Perijinan Perumahan',
        ];

        $data_inputs = collect($components)->map(function ($value, $index)
        {
            return [
                'name' => $value,
                'slug_name' => Str::slug($value),
            ];
        });

        $data_inputs = $data_inputs->toArray();

        DB::table('legalitas_perusahaans')->insert($data_inputs);
    }
}
