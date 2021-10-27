<?php

namespace App\Http\Livewire\Keuangan;

use Livewire\Component;
use App\Models\{
    Master\MsCode,
    Master\MsCodePaket,
    Master\MsSubCode,

    Keuangan\PengajuanDana,
};

class LvPengajuanDana extends Component
{
    public $divisi_id;
    public $paket_code_id;

    public function mount()
    {
        $this->divisi_id = MsCode::where('code', 300)->firstOrFail()->id;
        $this->paket_code_id = MsCodePaket::select('id')->where(['parent_code_id' => $this->divisi_id, 'code' => '300P1'])->firstOrFail()->id;
    }
    
    public function render()
    {
        $data['pakets'] = MsSubCode::where(['parent_code_id' => $this->divisi_id, 'paket_code_id' => $this->paket_code_id])->get();
        $data['pengajuan_danas'] = PengajuanDana::with(['paket', 'item'])->get();
        
        return view('livewire.keuangan.lv-pengajuan-dana')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
}
