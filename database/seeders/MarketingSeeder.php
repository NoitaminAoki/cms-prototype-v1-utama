<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class MarketingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            'Laporan Kegiatan Marketing',
            'Laporan Progress Marketing',
        ];

        $data_inputs = collect($components)->map(function ($value, $index)
        {
            return [
                'name' => $value,
                'slug_name' => Str::slug($value),
            ];
        });

        $data_inputs = $data_inputs->toArray();

        DB::table('marketings')->insert($data_inputs);
    }
}
