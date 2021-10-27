<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class AsetPerusahaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            'Aset Tanah Kavling',
            'Aset Tanah Kavling di Luar',
            'Aset Bangunan',
            'Aset Pasum',
        ];

        $data_inputs = collect($components)->map(function ($value, $index)
        {
            return [
                'name' => $value,
                'slug_name' => Str::slug($value),
            ];
        });

        $data_inputs = $data_inputs->toArray();

        DB::table('aset_perusahaans')->insert($data_inputs);
    }
}
