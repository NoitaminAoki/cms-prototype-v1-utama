<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\{
    Keuangan\JurnalHarian,
};
use App\Helpers\{
    StringGenerator,
    SectorData,
};

class LvJurnalHarian extends Component
{
    use WithFileUploads;
    
    protected $listeners = [
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    private $sector_properties;
    
    public $page_attribute = [
        'title' => 'Jurnal Harian',
    ];
    public $page_permission = [
        'add' => 'jurnal-harian add',
        'delete' => 'jurnal-harian delete',
    ];
    
    public $control_tabs = [
        'sector_list' => true,
        'sector_detail' => false,
    ];
    
    public $paket_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;
    
    public $selected_item;
    public $selected_url;
    
    public $wilayah;
    public $selected_sector_id;
    public $sector_name;
    
    
    public function mount()
    {
        $this->wilayah = SectorData::getAllNames();
    }
    
    public function render()
    {
        $data['sector_items'] = [];
        if($this->selected_sector_id) {
            $exists = $this->setSector($this->selected_sector_id, ['notification' => true]);
            if ($exists) {
                $this->sector_name = $this->sector_properties['name'];
                Config::set('database.connections.sector_db.database', $this->sector_properties['db_name']);
                DB::purge('sector_db');
                $data['sector_items'] = JurnalHarian::on('sector_db')->get();
            }
        }
        
        $data['items'] = JurnalHarian::all();
        return view('livewire.pelaksanaan.keuangan.lv-jurnal-harian')
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
        $image_name = StringGenerator::fileName($this->file_image->extension());
        $image_path = Storage::disk('sector_disk_main')->putFileAs(JurnalHarian::BASE_PATH, $this->file_image, $image_name);
        
        $insert = JurnalHarian::create([
            'image_real_name' => $this->file_image->getClientOriginalName(),
            'image_name' => $image_name,
            'tanggal' => $date_now,
        ]);
        
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:show', ['type' => 'success', 'title' => 'Success!', 'message' => 'Successfully adding data.']);
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
    
    public function setItem($id, $sector_id = null)
    {
        $query = JurnalHarian::query();
        if ($sector_id) {
            $exists = $this->setSector($sector_id, ['notification' => true]);
            if ($exists) {
                Config::set('database.connections.sector_db.database', $this->sector_properties['db_name']);
                DB::purge('sector_db');
                $query = JurnalHarian::on('sector_db');
            }
        }
        $item = $query->where('id', $id)->firstOrFail();
        $this->selected_item = $item->toArray();
        
        $this->selected_url = route('files.image.stream', ['path' => $item->sector_id.'/'.$item->base_path, 'name' => $item->image_name]);
    }
    
    public function setSector($sector_id, $attributes = ['notification' => false])
    {
        $sector_properties = SectorData::getPropertiesById($sector_id);
        if($sector_properties) {
            $this->sector_properties = $sector_properties;
            return true;
        }
        if($attributes['notification']) {
            $this->dispatchBrowserEvent('notification:show', ['type' => 'warning', 'title' => 'Ops!', 'message' => "Sorry we can't find any data, try again later."]);
        }
        return false;
    }
    
    public function clearSector()
    {
        $this->selected_sector_id = null;
        $this->sector_name = null;
    }
    
    public function setSectorId($sector_id)
    {
        $exists = $this->setSector($sector_id, ['notification' => true]);
        if($exists) {
            $this->selected_sector_id = $sector_id;
            $this->control_tabs = [
                'sector_list' => false,
                'sector_detail' => true,
            ];
        }
    }
    
    public function downloadImage($sector_id = null)
    {
        $query = JurnalHarian::query();
        if ($sector_id) {
            $exists = $this->setSector($sector_id, ['notification' => true]);
            if ($exists) {
                Config::set('database.connections.sector_db.database', $this->sector_properties['db_name']);
                DB::purge('sector_db');
                $query = JurnalHarian::on('sector_db');
            }
        }
        $item = $query->where('id', $this->selected_item['id'])->firstOrFail();
        $path = $item->sector_id.'/'.$item->base_path.$item->image_name;
        
        return Storage::disk('sector_disk')->download($path, $item->image_real_name);
    }
    
    public function copyDataSector($id, $sector_id)
    {
        $exists = $this->setSector($sector_id, ['notification' => true]);
        if ($exists) {
            Config::set('database.connections.sector_db.database', $this->sector_properties['db_name']);
            DB::purge('sector_db');
            $item = JurnalHarian::on('sector_db')
            ->where('id', $id)
            ->firstOrFail();
            $re_item = $item->replicate();
            $re_item->setConnection('mysql');
            $re_item->sector_id = Config::get('app.sector_id');
            
            $old_path = $item->sector_id.'/'.$re_item->base_path.$re_item->image_name;
            $extension = pathinfo(Storage::disk('sector_disk')->path($old_path), PATHINFO_EXTENSION);
            $new_filename = StringGenerator::fileName($extension);
            $new_path = $re_item->sector_id.'/'.$re_item->base_path.$new_filename;
            
            $re_item->image_name = $new_filename;
            $re_item->save();
            Storage::disk('sector_disk')->copy($old_path, $new_path);

            return $this->dispatchBrowserEvent('notification:show', ['type' => 'success', 'title' => 'Success!', 'message' => 'Successfully storing data.']);
            // dd($re_item);
        }
        return;
    }
    
    public function delete($id)
    {
        $item = JurnalHarian::query()
        ->where('id', $id)
        ->firstOrFail();
        $path = $item->sector_id.'/'.$item->base_path.$item->image_name;
        Storage::disk('sector_disk')->delete($path);
        $item->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
