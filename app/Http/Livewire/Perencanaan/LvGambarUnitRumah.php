<?php

namespace App\Http\Livewire\Perencanaan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Perencanaan\GambarUnitRumah,
};
use App\Helpers\StringGenerator;

class LvGambarUnitRumah extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetInputTanggal' => 'setInputTanggal',
    ];

    public $page_attribute = [
        'title' => 'Gambar Unit Rumah',
    ];
    public $page_permission = [
        'add' => 'gambar-unit-rumah add',
        'delete' => 'gambar-unit-rumah delete',
    ];

    public $file_pdf;
    public $input_tanggal;
    public $iteration;

    public $selected_item;
    public $selected_url;
    
    public function render()
    {
        $data['items'] = GambarUnitRumah::all();
        return view('livewire.perencanaan.lv-gambar-unit-rumah')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function addItem()
    {
        $this->validate([
            'file_pdf' => 'required|mimes:pdf',
            'input_tanggal' => 'required|string',
        ]);
        $date_now = date('Y-m-d H:i:s', strtotime($this->input_tanggal));
        $pdf_name = StringGenerator::fileName($this->file_pdf->extension());
        $pdf_path = Storage::disk('sector_disk')->putFileAs(GambarUnitRumah::BASE_PATH, $this->file_pdf, $pdf_name);

        $insert = GambarUnitRumah::create([
            'pdf_real_name' => $this->file_pdf->getClientOriginalName(),
            'pdf_name' => $pdf_name,
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
        $this->reset('file_pdf', 'selected_item');
        $this->input_tanggal = date('m/d/Y');
        $this->iteration++;
    }

    public function setItem($id)
    {
        $item = GambarUnitRumah::findOrFail($id);
        $this->selected_item = $item;
        $this->selected_url = route('files.pdf.stream', ['path' => $item->base_path, 'name' => $item->pdf_name]);
    }

    public function downloadPdf()
    {
        $item= GambarUnitRumah::findOrFail($this->selected_item['id']);
        $path = $item->base_path.$item->pdf_name;
        
        return Storage::disk('sector_disk')->download($path, $item->pdf_real_name);
    }

    public function delete($id)
    {
        $item = GambarUnitRumah::findOrFail($id);
        $path = $item->base_path.$item->pdf_name;
        Storage::disk('sector_disk')->delete($path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
