<?php

namespace App\Http\Livewire\Perencanaan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Perencanaan\KonstruksiUnitRumah,
    Perencanaan\ItemUnitRumah,
};

class LvItemUnitRumah extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    public $page_attribute = [
        'title' => '',
    ];
    public $page_permission = [
        'add' => 'item-unit-rumah add',
        'delete' => 'item-unit-rumah delete',
    ];

    public $route_pdf_item = "pdf.perencanaan.item_unit_rumah";

    public $parent_id;
    public $file_pdf;
    public $input_tanggal;
    public $iteration;

    public $selected_item;
    public $selected_url;

    public function mount($slug)
    {
        $parent = KonstruksiUnitRumah::query()
        ->where('slug_name', $slug)
        ->firstOrFail();

        $this->parent_id = $parent->id;
        $this->page_attribute['title'] = $parent->type;
    }

    public function render()
    {
        $data['items'] = ItemUnitRumah::query()
        ->where('konstruksi_unit_id', $this->parent_id)
        ->get();

        return view('livewire.perencanaan.lv-item-unit-rumah')
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
        $pdf_name = 'pdf_item_unit_rumah_'.Date('YmdHis').'.'.$this->file_pdf->extension();
        $pdf_path = Storage::putFileAs('pdf/perencanaan/item_unit_rumah', $this->file_pdf, $pdf_name);

        $insert = ItemUnitRumah::create([
            'konstruksi_unit_id' => $this->parent_id,
            'pdf_name' => $this->file_pdf->getClientOriginalName(),
            'pdf_path' => $pdf_path,
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
        $item = ItemUnitRumah::findOrFail($id);
        $this->selected_item = $item;
        $this->selected_url = route('pdf.perencanaan.item_unit_rumah', ['id' => $item->id]);
    }

    public function downloadPdf($pdf_number = 1)
    {
        $file = ItemUnitRumah::findOrFail($this->selected_item['id']);
        $path = storage_path('app/'.$file->pdf_path);
        return response()->download($path, $file->pdf_name);
    }

    public function delete($id)
    {
        $item = ItemUnitRumah::findOrFail($id);
        Storage::delete($item->pdf_path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
