<?php

namespace App\Http\Livewire\Master;

use Livewire\Component;
use App\Models\{
    Master\MsCode,
    Master\MsSubCode,
};
use Illuminate\Support\Str;

class LvMsSubCode extends Component
{
    public $parent_code_id;
    public $code;
    public $name;

    public function mount($parent_code_id)
    {
        $this->parent_code_id = $parent_code_id;
    }

    public function render()
    {
        $data['parent_code'] = MsCode::findOrFail($this->parent_code_id);
        $data['sub_codes'] = MsSubCode::where('parent_code_id', $this->parent_code_id)->get();

        return view('livewire.master.lv-ms-sub-code')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
    
    public function addSubCode()
    {
        $this->validate([
            'parent_code_id' => 'required|integer',
            'code' => 'required|integer',
            'name' => 'required|string',
        ]);

        $insert = MsSubCode::create([
            'parent_code_id' => $this->parent_code_id, 
            'code' => $this->code, 
            'nama' => Str::upper($this->name)
        ]);

        $this->resetInput();
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }

    public function resetInput()
    {
        $this->reset(['parent_code_id', 'code', 'name']);
    }
}
