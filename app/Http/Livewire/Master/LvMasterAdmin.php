<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;

class LvMasterAdmin extends Component
{

    public function render()
    {
        return view('livewire.master.lv-master-admin')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
}
