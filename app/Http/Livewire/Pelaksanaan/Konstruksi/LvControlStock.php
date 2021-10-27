<?php

namespace App\Http\Livewire\Pelaksanaan\Konstruksi;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Konstruksi\ControlStock,
};

class LvControlStock extends Component
{
    use WithFileUploads;
    
    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    public $page_attribute = [
        'title' => 'Control Stock Material',
    ];
    public $page_permission = [
        'add' => 'control-stock add',
        'delete' => 'control-stock delete',
    ];
    
    public $control_tabs = [
        'list' => true,
        'detail' => false,
    ];
    
    public $route_image_item = "image.konstruksi.control_stock";
    
    public $paket_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;
    
    public $items;
    public $selected_item_group = [];
    public $selected_group_name;
    public $selected_item;
    public $selected_url;
    
    public function render()
    {
        $items = ControlStock::query()
        ->select('*')
        ->selectRaw('DATE_FORMAT(tanggal, "%M %Y") as date')
        ->orderBy('tanggal', 'ASC')
        ->get()
        ->groupBy('date');

        $this->items = collect($items)->map(function ($values, $index)
        {
            return [
                'name' => $index,
                'items' => $values,
            ];
        });
        
        if ($this->selected_group_name) {
            $item = $this->items->where('name', $this->selected_group_name)->first();
            $this->selected_item_group = $item['items'] ?? [];
        }
        
        return view('livewire.pelaksanaan.konstruksi.lv-control-stock')
        ->with([])
        ->layout('layouts.dashboard.main');
    }
    
    public function addItem()
    {
        $this->validate([
            'file_image' => 'required|image',
            'input_tanggal' => 'required|string',
        ]);
        $date_now = date('Y-m-d H:i:s', strtotime($this->input_tanggal));
        $image_name = 'image_control_stock_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/konstruksi/control_stock', $this->file_image, $image_name);
        
        $insert = ControlStock::create([
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
        $resume = ControlStock::findOrFail($id);
        $this->selected_item = $resume;
        $this->selected_url = route('image.konstruksi.control_stock', ['id' => $resume->id]);
    }
    
    public function setGroupName($name)
    {
        $this->selected_group_name = $name;
        $this->control_tabs = [
            'list' => false,
            'detail' => true,
        ];
    }
    
    public function openList()
    {
        $this->control_tabs = [
            'list' => true,
            'detail' => false,
        ];
    }
    
    public function downloadImage()
    {
        $file = ControlStock::findOrFail($this->selected_item['id']);
        $path = storage_path('app/'.$file->image_path);
        
        return response()->download($path, $file->image_name);
    }
    
    public function delete($id)
    {
        $item = ControlStock::findOrFail($id);
        Storage::delete($item->image_path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
