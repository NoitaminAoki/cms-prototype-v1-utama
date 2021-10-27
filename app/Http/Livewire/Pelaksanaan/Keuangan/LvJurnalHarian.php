<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Keuangan\JurnalHarian,
};

class LvJurnalHarian extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetInputTanggal' => 'setInputTanggal',
    ];

    public $file_image;
    public $input_tanggal;
    public $iteration;

    public $selected_jurnal_harian;
    public $selected_url;
    
    public function render()
    {
        $data['jurnal_harians'] = JurnalHarian::all();
        return view('livewire.pelaksanaan.keuangan.lv-jurnal-harian')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function addJurnalHarian()
    {
        $this->validate([
            'file_image' => 'required|image',
            'input_tanggal' => 'required|string',
        ]);
        $date_now = date('Y-m-d H:i:s', strtotime($this->input_tanggal));
        $image_name = 'image_jurnal_harian_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/keuangan/jurnal_harian', $this->file_image, $image_name);

        $insert = JurnalHarian::create([
            'image_name' => $this->file_image->getClientOriginalName(),
            'image_path' => $image_path,
            'tanggal' => $date_now,
        ]);

        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }

    public function setInputTanggal($value)
    {
        $this->input_tanggal = $value;
    }

    public function resetInput()
    {
        $this->reset('file_image', 'selected_jurnal_harian');
        $this->input_tanggal = date('m/d/Y');
        $this->iteration++;
    }

    public function setJurnalHarian($id)
    {
        $pengajuan = JurnalHarian::findOrFail($id);
        $this->selected_jurnal_harian = $pengajuan;
        $this->selected_url = route('image.keuangan.jurnal_harian', ['id' => $pengajuan->id]);
    }

    public function downloadImage()
    {
        $file = JurnalHarian::findOrFail($this->selected_jurnal_harian['id']);
        $path = storage_path('app/'.$file->image_path);
        
        return response()->download($path, $file->image_name);
    }

    public function delete($id)
    {
        $jurnal_harian = JurnalHarian::findOrFail($id);
        Storage::delete($jurnal_harian->image_path);
        $jurnal_harian->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
