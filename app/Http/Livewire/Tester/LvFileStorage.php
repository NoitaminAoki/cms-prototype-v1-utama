<?php

namespace App\Http\Livewire\Tester;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Models\Master\{
    MsCode,
};
use DB;

class LvFileStorage extends Component
{
    public $divisi;

    public function render()
    {
        return view('livewire.tester.lv-file-storage')
        ->with([])
        ->layout('layouts.dashboard.main');
    }

    public function createDir()
    {
        try {
            Storage::disk('custom')->makeDirectory('tester');
            dd('success');
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function testConnection()
    {
        $db_name = 'cms_prototype_v1_db';
        Config::set('database.connections.sector_db.database', $db_name);
        DB::purge('sector_db');

        $divisi = MsCode::on('sector_db')
        ->select('ms_codes.*', 'd1_mc.nama as nama_d1')
        ->leftJoin('cms_prototype_db.ms_codes as d1_mc', 'ms_codes.id', '=', 'd1_mc.id')
        ->get();

        $this->divisi = $divisi;
    }

    public function testDirectory()
    {
        $dir = '../../';
        $subdomain_dir = 'cms-prototype-v1';
        $file_name = 'avatar-5.png';
        Config::set('filesystems.disks.sector_disk.root', $dir . $subdomain_dir);
        // dd($path);
        // if (file_exists($path)) {
            
            return Storage::disk('sector_disk')->download('storage/images/' . $file_name, $file_name);
            
        // }
    }
}
