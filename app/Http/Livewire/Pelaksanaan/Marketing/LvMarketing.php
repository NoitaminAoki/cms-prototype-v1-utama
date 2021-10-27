<?php

namespace App\Http\Livewire\Pelaksanaan\Marketing;

use Livewire\Component;
use App\Models\{
    Marketing\Marketing,
};
use App\Helpers\Converter;

class LvMarketing extends Component
{
    public $route_item_name = 'pelaksanaan.marketing.item.index';

    public function render()
    {
        $data['items'] = Marketing::all();

        $data['converter_class'] = Converter::class;

        return view('livewire.pelaksanaan.marketing.lv-marketing')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
}
