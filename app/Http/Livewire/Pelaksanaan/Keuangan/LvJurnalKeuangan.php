<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;

class LvJurnalKeuangan extends Component
{
    public function render()
    {
        return view('livewire.pelaksanaan.keuangan.lv-jurnal-keuangan')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
