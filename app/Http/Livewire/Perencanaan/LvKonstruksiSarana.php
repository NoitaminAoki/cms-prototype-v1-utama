<?php

namespace App\Http\Livewire\Perencanaan;

use Livewire\Component;
use App\Models\{
    Perencanaan\KonstruksiSarana,
};
use App\Helpers\Converter;

class LvKonstruksiSarana extends Component
{
    public $route_item_name = 'perencanaan.konstruksi_sarana.item.index';

    public function render()
    {
        $data['items'] = KonstruksiSarana::all();

        $data['converter_class'] = Converter::class;

        return view('livewire.perencanaan.lv-konstruksi-sarana')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
}
