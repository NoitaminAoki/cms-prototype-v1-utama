<?php

namespace App\Http\Livewire\Pelaksanaan\Konstruksi;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Konstruksi\ProgressKemajuan,
    Konstruksi\ItemProgressKemajuan,
};

class LvItemProgressKemajuan extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    public $page_attribute = [
        'title' => '',
    ];
    public $page_permission = [
        'add' => 'item-progress-kemajuan add',
        'delete' => 'item-progress-kemajuan delete',
    ];

    public $control_tabs = [
        'list' => true,
        'detail' => false,
    ];

    public $route_image_item = "image.konstruksi.item_progress_kemajuan";

    public $parent_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;

    public $items;
    public $selected_item_group = [];
    public $selected_group_name;
    public $selected_item;
    public $selected_url;

    public function mount($slug)
    {
        $parent = ProgressKemajuan::query()
        ->where('slug_name', $slug)
        ->firstOrFail();

        $this->parent_id = $parent->id;
        $this->page_attribute['title'] = $parent->name;
    }

    public function render()
    {
        $items = ItemProgressKemajuan::query()
        ->select('*')
        ->selectRaw('DATE_FORMAT(tanggal, "%M %Y") as date')
        ->where('progress_kemajuan_id', $this->parent_id)
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

        return view('livewire.pelaksanaan.konstruksi.lv-item-progress-kemajuan')
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
        $image_name = 'image_item_progress_kemajuan_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/pelaksanaan/konstruksi/item_progress_kemajuan', $this->file_image, $image_name);

        $insert = ItemProgressKemajuan::create([
            'progress_kemajuan_id' => $this->parent_id,
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
        $item = ItemProgressKemajuan::findOrFail($id);
        $this->selected_item = $item;
        $this->selected_url = route('image.konstruksi.item_progress_kemajuan', ['id' => $item->id]);
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

    public function downloadImage($image_number = 1)
    {
        $file = ItemProgressKemajuan::findOrFail($this->selected_item['id']);
        $path = storage_path('app/'.$file->image_path);
        return response()->download($path, $file->image_name);
    }

    public function delete($id)
    {
        $item = ItemProgressKemajuan::findOrFail($id);
        Storage::delete($item->image_path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
