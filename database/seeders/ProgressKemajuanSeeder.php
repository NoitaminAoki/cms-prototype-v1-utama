<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class ProgressKemajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $components = [
            'Progress Gudang',
            'Progress Lahan',
            'Progress Rumah',
        ];

        $data_inputs = collect($components)->map(function ($value, $index)
        {
            return [
                'name' => $value,
                'slug_name' => Str::slug($value),
            ];
        });

        $data_inputs = $data_inputs->toArray();

        DB::table('progress_kemajuans')->insert($data_inputs);
    }
}
