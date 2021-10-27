<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;

class LvKeuangan extends Component
{
    public function render()
    {
        return view('livewire.pelaksanaan.keuangan.lv-keuangan')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
