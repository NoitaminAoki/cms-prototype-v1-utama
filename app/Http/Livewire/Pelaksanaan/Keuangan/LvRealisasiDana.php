<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Keuangan\RealisasiDana,
};

class LvRealisasiDana extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetInputTanggal' => 'setInputTanggal',
    ];

    public $page_attribute = [
        'title' => 'Realisasi Dana',
    ];
    public $page_permission = [
        'add' => 'realisasi-dana add',
        'delete' => 'realisasi-dana delete',
    ];

    public $route_image_item = "image.keuangan.realisasi_dana";

    public $paket_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;

    public $selected_item;
    public $selected_url;
    
    public function render()
    {
        $data['items'] = RealisasiDana::all();
        return view('livewire.pelaksanaan.keuangan.lv-realisasi-dana')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function addItem()
    {
        $this->validate([
            'file_image' => 'required|image',
            'input_tanggal' => 'required|string',
        ]);
        $date_now = date('Y-m-d H:i:s', strtotime($this->input_tanggal));
        $image_name = 'image_realisasi_dana_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/keuangan/realisasi_dana', $this->file_image, $image_name);

        $insert = RealisasiDana::create([
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
        $this->reset('file_image', 'selected_item');
        $this->input_tanggal = date('m/d/Y');
        $this->iteration++;
    }

    public function setItem($id)
    {
        $resume = RealisasiDana::findOrFail($id);
        $this->selected_item = $resume;
        $this->selected_url = route('image.keuangan.realisasi_dana', ['id' => $resume->id]);
    }

    public function downloadImage()
    {
        $file = RealisasiDana::findOrFail($this->selected_item['id']);
        $path = storage_path('app/'.$file->image_path);
        
        return response()->download($path, $file->image_name);
    }

    public function delete($id)
    {
        $item = RealisasiDana::findOrFail($id);
        Storage::delete($item->image_path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
