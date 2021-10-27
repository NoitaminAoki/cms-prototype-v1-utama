<?php

namespace App\Http\Livewire\Pelaksanaan\Umum;

use Livewire\Component;
use App\Models\{
    Umum\AsetPerusahaan,
};
use App\Helpers\Converter;

class LvAsetPerusahaan extends Component
{
    public $route_item_name = 'pelaksanaan.umum.aset_perusahaan.item.index';

    public function render()
    {
        $data['items'] = AsetPerusahaan::all();

        $data['converter_class'] = Converter::class;

        return view('livewire.pelaksanaan.umum.lv-aset-perusahaan')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
}
