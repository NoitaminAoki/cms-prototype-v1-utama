<?php

namespace App\Http\Livewire\Keuangan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Keuangan\PengajuanDana,
    Keuangan\MaterialPengajuanDana,
    Keuangan\RealisasiDana,
};
use Illuminate\Support\Facades\DB;

class LvRealisasiDana extends Component
{
    use WithFileUploads;

    public $selected_realisasi;
    public $selected_url;
    public $material_pengajuan_dana = [];
    public $total_harga_material = 0;

    public $show_modal = false;

    public $file_upload_bukti;
    public $iteration;

    public function mount()
    {
        $this->realisasi_dana = new RealisasiDana;
    }

    public function render()
    {
        $data['pengajuan_danas'] = PengajuanDana::with(['realisasi', 'paket', 'item'])->get();
        
        return view('livewire.keuangan.lv-realisasi-dana')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function setRealisasiDana($id)
    {
        $this->show_modal = true;
        $realisasi_dana = RealisasiDana::query()
        ->with(['divisi', 'pengajuan.paket', 'pengajuan.item'])
        ->where('id', $id)
        ->firstOrFail();

        $material = MaterialPengajuanDana::query()
        ->with(['material.ms_satuan', 'material_realisasi'])
        ->where('pengajuan_dana_id', $realisasi_dana->pengajuan_dana_id)
        ->get();

        $this->selected_realisasi = $realisasi_dana;
        $this->material_pengajuan_dana = $material;
        $this->total_harga_material = 0;

        $this->selected_url = route('file.keuangan.realisasi_dana', ['id' => $realisasi_dana->id]);

    }


    public function setRealisasiId($id)
    {
        $this->selected_realisasi = RealisasiDana::query()
        ->with(['divisi', 'pengajuan.paket', 'pengajuan.item'])
        ->where('id', $id)
        ->firstOrFail();
    }

    public function uploadFileBukti()
    {
        $this->validate([
            'file_upload_bukti' => 'required|image|max:5120'
        ]);

        DB::beginTransaction();

        $realisasi = RealisasiDana::query()
        ->with('pengajuan')
        ->where('id', $this->selected_realisasi->id)
        ->firstOrFail();

        $name = $realisasi->format_code.'_'.Date('YmdHis').'.'.$this->file_upload_bukti->extension();
        $path = Storage::putFileAs('images/keuangan/realisasi_dana/'.$realisasi->format_code, $this->file_upload_bukti, $name);

        $realisasi->bukti_transfer_path = $path;
        $realisasi->status = 'complete';

        $realisasi->pengajuan->status_pengajuan = 'complete';

        $realisasi->save();
        $realisasi->pengajuan->save();

        DB::commit();

        $this->resetInput();

        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully updating data.']);
    }

    public function resetInput()
    {
        $this->reset(['file_upload_bukti', 'selected_realisasi']);
        $this->iteration++;
    }
}
