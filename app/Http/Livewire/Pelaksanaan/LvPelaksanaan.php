<?php

namespace App\Http\Livewire\Pelaksanaan;

use Livewire\Component;

class LvPelaksanaan extends Component
{
    public function render()
    {
        return view('livewire.pelaksanaan.lv-pelaksanaan')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
