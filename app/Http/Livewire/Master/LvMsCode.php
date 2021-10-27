<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\{
    Perencanaan\Divisi,

    Master\MsCode,
};
use Illuminate\Support\Str;

class LvMsCode extends Component
{
    protected $listeners = [
        'evSetDivisi' => 'setDivisi',
    ];

    public $divisi_id;
    public $code;
    public $name;

    public function render()
    {
        $data['codes'] = MsCode::all();
        $data['divisis'] = Divisi::all();

        return view('livewire.master.lv-ms-code')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function addCode()
    {
        $this->validate([
            'divisi_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string',
        ]);

        $insert = MsCode::create([
            'divisi_id' => $this->divisi_id, 
            'code' => $this->code, 
            'nama' => Str::upper($this->name)
        ]);

        $this->resetInput();
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }

    public function resetInput()
    {
        $this->reset(['divisi_id', 'code', 'name']);
    }

    public function setDivisi($divisi_id)
    {
        $this->divisi_id = $divisi_id;
    }
}
