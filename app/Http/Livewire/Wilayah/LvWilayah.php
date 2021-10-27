<?php

namespace App\Http\Livewire\Wilayah;

use Livewire\Component;

class LvWilayah extends Component
{
    public function render()
    {
        $data = [];
        return view('livewire.wilayah.lv-wilayah')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
}
