<?php

namespace App\Http\Livewire\Pelaksanaan\Umum;

use Livewire\Component;

class LvUmum extends Component
{
    public function render()
    {
        return view('livewire.pelaksanaan.umum.lv-umum')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
