<?php

namespace App\Http\Livewire\Pelaksanaan\Konstruksi;

use Livewire\Component;

class LvKonstruksi extends Component
{
    public function render()
    {
        return view('livewire.pelaksanaan.konstruksi.lv-konstruksi')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
