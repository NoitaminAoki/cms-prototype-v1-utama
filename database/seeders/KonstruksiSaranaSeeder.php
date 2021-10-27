<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class KonstruksiSaranaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            'Gudang Material',
            'Saluran Drainase',
            'Jalan Kawasan',
            'Pagar Kawasan',
            'Gerbang',
            'Taman & Area Bermain',
        ];

        $data_inputs = collect($components)->map(function ($value, $index)
        {
            return [
                'name' => $value,
                'slug_name' => Str::slug($value),
            ];
        });

        $data_inputs = $data_inputs->toArray();

        DB::table('konstruksi_saranas')->insert($data_inputs);
    }
}
