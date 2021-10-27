<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MsSubCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ms_sub_codes')->insert([
            ['id' => 1, 'parent_code_id' => 2, 'code' => 210, 'nama' => 'ALAT TULIS KANTOR'],
            ['id' => 2, 'parent_code_id' => 2, 'code' => 220, 'nama' => 'BIAYA OPERASIONAL KANTOR'],
            ['id' => 3, 'parent_code_id' => 2, 'code' => 230, 'nama' => 'GAJI PEGAWAI'],
            ['id' => 4, 'parent_code_id' => 2, 'code' => 240, 'nama' => 'PAJAK - PAJAK'],
            ['id' => 5, 'parent_code_id' => 2, 'code' => 250, 'nama' => 'PENGEMBALIAN PINJAMAN'],
            ['id' => 6, 'parent_code_id' => 2, 'code' => 260, 'nama' => 'LAIN - LAIN'],
            ['id' => 7, 'parent_code_id' => 2, 'code' => 260, 'nama' => 'PRIVE'],
        ]);

        DB::table('ms_sub_codes')->insert([
            ['id' => 8, 'paket_code_id' => null, 'parent_code_id' => 3, 'code' => '310', 'nama' => 'OPERASIONAL KANTOR', 'has_child' => false],
            ['id' => 9, 'paket_code_id' => 1, 'parent_code_id' => 3, 'code' => 320, 'nama' => 'INFRASTRUKTUR PROYEK', 'has_child' => false],
            ['id' => 10, 'paket_code_id' => 1, 'parent_code_id' => 3, 'code' => 330, 'nama' => 'STRUKTUR BANGUNAN UNIT RUMAH', 'has_child' => false],
            ['id' => 11, 'paket_code_id' => 1, 'parent_code_id' => 3, 'code' => 340, 'nama' => 'PASAR MODERN', 'has_child' => false],
            ['id' => 12, 'paket_code_id' => 1, 'parent_code_id' => 3, 'code' => 350, 'nama' => 'PENGERJAAN UTILITAS DAN JARINGAN', 'has_child' => false],
            ['id' => 13, 'paket_code_id' => 1, 'parent_code_id' => 3, 'code' => 360, 'nama' => 'FASILITAS UMUM / SOSIAL', 'has_child' => false],
            ['id' => 14, 'paket_code_id' => null, 'parent_code_id' => 3, 'code' => 370, 'nama' => 'POS PERALATAN KERJA', 'has_child' => true],
            ['id' => 15, 'paket_code_id' => null, 'parent_code_id' => 3, 'code' => 380, 'nama' => 'POS BIAYA BBM', 'has_child' => false],
            ['id' => 16, 'paket_code_id' => null, 'parent_code_id' => 3, 'code' => 390, 'nama' => 'POS MATERIAL', 'has_child' => true],
        ]);

        DB::table('ms_sub_codes')->insert([
            ['id' => 17, 'parent_code_id' => 4, 'code' => 410, 'nama' => 'BIAYA PROMOSI'],
            ['id' => 18, 'parent_code_id' => 4, 'code' => 420, 'nama' => 'BIAYA PENJUALAN'],
        ]);

        DB::table('ms_sub_codes')->insert([
            ['id' => 19, 'parent_code_id' => 5, 'code' => 510, 'nama' => 'PERIJINAN & LEGALITAS KEAMANAN'],
            ['id' => 20, 'parent_code_id' => 5, 'code' => 520, 'nama' => 'KEAMANAN LINGKUNGAN & SOSIAL'],
        ]);
    }
}
