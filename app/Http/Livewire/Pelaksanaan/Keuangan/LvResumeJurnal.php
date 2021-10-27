<?php

namespace App\Http\Livewire\Pelaksanaan\Keuangan;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\{
    Keuangan\ResumeJurnal,
};

class LvResumeJurnal extends Component
{
    use WithFileUploads;

    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetInputTanggal' => 'setInputTanggal',
    ];

    public $paket_id;
    public $file_image;
    public $input_tanggal;
    public $iteration;

    public $selected_resume_jurnal;
    public $selected_url;
    
    public function render()
    {
        $data['resume_jurnals'] = ResumeJurnal::all();
        return view('livewire.pelaksanaan.keuangan.lv-resume-jurnal')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function addResumeJurnal()
    {
        $this->validate([
            'file_image' => 'required|image',
            'input_tanggal' => 'required|string',
        ]);
        $date_now = date('Y-m-d H:i:s', strtotime($this->input_tanggal));
        $image_name = 'image_resume_jurnal_'.Date('YmdHis').'.'.$this->file_image->extension();
        $image_path = Storage::putFileAs('images/keuangan/resume_jurnal', $this->file_image, $image_name);

        $insert = ResumeJurnal::create([
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
        $this->reset('file_image', 'selected_resume_jurnal');
        $this->input_tanggal = date('m/d/Y');
        $this->iteration++;
    }

    public function setResumeJurnal($id)
    {
        $resume = ResumeJurnal::findOrFail($id);
        $this->selected_resume_jurnal = $resume;
        $this->selected_url = route('image.keuangan.resume_jurnal', ['id' => $resume->id]);
    }

    public function downloadImage()
    {
        $file = ResumeJurnal::findOrFail($this->selected_resume_jurnal['id']);
        $path = storage_path('app/'.$file->image_path);
        
        return response()->download($path, $file->image_name);
    }

    public function delete($id)
    {
        $resume_jurnal = ResumeJurnal::findOrFail($id);
        Storage::delete($resume_jurnal->image_path);
        $resume_jurnal->delete();
        $this->resetInput();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
