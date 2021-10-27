<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ms_codes')->insert([
            ['divisi_id' => 1, 'code' => 100, 'nama' => 'KAS BESAR'],
            ['divisi_id' => 2, 'code' => 200, 'nama' => 'OPERASIONAL / MANAGEMENT'],
            ['divisi_id' => 3, 'code' => 300, 'nama' => 'ARUS KAS - DIVISI KONTRUKSI'],
            ['divisi_id' => 4, 'code' => 400, 'nama' => 'ARUS KAS - DIVISI MARKETING'],
            ['divisi_id' => 5, 'code' => 500, 'nama' => 'ARUS KAS - DIVISI UMUM'],
        ]);
    }
}
