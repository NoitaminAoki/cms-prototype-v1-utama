<?php

namespace App\Http\Livewire\Pelaksanaan\Marketing;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Marketing\Marketing,
    Marketing\ItemMarketing,
};

class LvItemMarketing extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    public $page_attribute = [
        'title' => '',
    ];
    public $page_permission = [
        'add' => 'item-marketing add',
        'delete' => 'item-marketing delete',
    ];

    public $route_image_item = "image.marketing.item_marketing";

    public $parent_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;

    public $selected_item;
    public $selected_url;

    public function mount($slug)
    {
        $parent = Marketing::query()
        ->where('slug_name', $slug)
        ->firstOrFail();

        $this->parent_id = $parent->id;
        $this->page_attribute['title'] = $parent->name;
    }

    public function render()
    {
        $data['items'] = ItemMarketing::query()
        ->where('marketing_id', $this->parent_id)
        ->get();

        return view('livewire.pelaksanaan.marketing.lv-item-marketing')
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
        $image_name = 'image_item_marketing_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/pelaksanaan/marketing/item_marketing', $this->file_image, $image_name);

        $insert = ItemMarketing::create([
            'marketing_id' => $this->parent_id,
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
        $item = ItemMarketing::findOrFail($id);
        $this->selected_item = $item;
        $this->selected_url = route('image.marketing.item_marketing', ['id' => $item->id]);
    }

    public function downloadImage($image_number = 1)
    {
        $file = ItemMarketing::findOrFail($this->selected_item['id']);
        $path = storage_path('app/'.$file->image_path);
        return response()->download($path, $file->image_name);
    }

    public function delete($id)
    {
        $item = ItemMarketing::findOrFail($id);
        Storage::delete($item->image_path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}