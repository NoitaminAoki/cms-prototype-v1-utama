<?php

namespace App\Http\Livewire\Perencanaan;

use Livewire\Component;

class LvPerencanaan extends Component
{
    public function render()
    {
        return view('livewire.perencanaan.lv-perencanaan')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
