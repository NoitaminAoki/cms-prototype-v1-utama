<?php

namespace App\Http\Livewire\Keuangan;

use Livewire\Component;
use App\Models\{
    Keuangan\KasBesar,
};

class LvKasBesar extends Component
{
    public $selected_kas_besar_id;
    public $input_kode_transaksi_bank;
    public $input_tipe_transaksi;
    public $input_sumber;
    public $input_jumlah;
    
    
    public function render()
    {
        $data['kas_besars'] = KasBesar::all();
        
        return view('livewire.keuangan.lv-kas-besar')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
    
    public function addKasBesar()
    {
        $this->validate([
            'input_tipe_transaksi' => 'required|string',
            'input_sumber' => 'required|string',
            'input_jumlah' => 'required|integer',
        ]);
        
        $insert = KasBesar::create([
            'tipe_transaksi' => $this->input_tipe_transaksi,
            'sumber' => $this->input_sumber,
            'jumlah' => $this->input_jumlah,
        ]);
        
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }
    
    public function resetInput()
    {
        $this->reset(['input_kode_transaksi_bank', 'input_tipe_transaksi', 'input_sumber', 'input_jumlah']);
    }
    
    public function setKasBesar($id)
    {
        $kas_besar = KasBesar::findOrFail($id);
        
        $this->selected_kas_besar_id = $kas_besar->id;
        $this->input_kode_transaksi_bank = $kas_besar->kode_transaksi_bank;
        $this->input_tipe_transaksi = $kas_besar->tipe_transaksi;
        $this->input_sumber = $kas_besar->sumber;
        $this->input_jumlah = $kas_besar->jumlah;
    }

    public function updateKasBesar()
    {
        $kas_besar = KasBesar::findOrFail($this->selected_kas_besar_id);

        $kas_besar->id = $this->selected_kas_besar_id;
        $kas_besar->kode_transaksi_bank = $this->input_kode_transaksi_bank;
        $kas_besar->tipe_transaksi = $this->input_tipe_transaksi;
        $kas_besar->sumber = $this->input_sumber;
        $kas_besar->jumlah = $this->input_jumlah;
        $kas_besar->save();
        
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully updating data.']);
    }

    public function delete($id)
    {
        $kas_besar = KasBesar::findOrFail($id);
        if($kas_besar->kode_transaksi_bank) {
            return ['status_code' => 403, 'message' => 'Unable to delete data.'];
        }
        $kas_besar->delete();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
