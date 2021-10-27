<?php

namespace App\Http\Livewire\Tester;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class LvFileStorage extends Component
{
    public function render()
    {
        return view('livewire.tester.lv-file-storage')
        ->with([])
        ->layout('layouts.dashboard.main');
    }

    public function createDir()
    {
        try {
            Storage::disk('custom')->makeDirectory('tester');
            dd('success');
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
