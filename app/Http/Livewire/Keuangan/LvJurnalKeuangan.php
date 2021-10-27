<?php

namespace App\Http\Livewire\Keuangan;

use Livewire\Component;
use App\Models\{
    Master\MsCode,
    Master\MsCodePaket,
    Master\MsSubCode,

    Keuangan\Kwitansi,
};
use App\Exports\Keuangan\JurnalKwitansiExport;
use Maatwebsite\Excel\Facades\Excel;

class LvJurnalKeuangan extends Component
{
    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetTanggal' => 'setTanggal',
    ];

    public $list_kwitansi = [];
    public $control_tabs = [
        'keuangan' => true,
        'kwitansi' => false,
        'kas_besar' => false,
    ];

    public $divisi_id;
    public $paket_code_id;
    public $paket_id;
    public $filter_tanggal;

    public function mount()
    {
        $this->divisi_id = MsCode::where('code', 300)->firstOrFail()->id;
        $this->paket_code_id = MsCodePaket::select('id')->where(['parent_code_id' => $this->divisi_id, 'code' => '300P1'])->firstOrFail()->id;
    }

    public function render()
    {
        $data['pakets'] = MsSubCode::where(['parent_code_id' => $this->divisi_id, 'paket_code_id' => $this->paket_code_id])->get();
        return view('livewire.keuangan.lv-jurnal-keuangan')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }

    public function setListKwitansi()
    {
        $filter = [];
        $arr_tanggal = [];
        if($this->filter_tanggal) {
            $start_date = date('Y-m-1 00:00:00', strtotime($this->filter_tanggal));
            $end_date = date('Y-m-t 00:00:00', strtotime($this->filter_tanggal));
            $arr_tanggal = [$start_date, $end_date];
        }
        if($this->paket_id) {
            $filter['paket_id'] = $this->paket_id;
        }

        $this->list_kwitansi = Kwitansi::query()
        ->with([
            'realisasi_danas' => function ($query) use($filter, $arr_tanggal)
            {
                $query->with(['material_pengajuans.material.ms_satuan', 'pengajuan.item:id,sub_divisi_id,nama'])
                ->leftJoin('pengajuan_danas as pd', 'pd.id', 'realisasi_danas.pengajuan_dana_id')
                ->when($filter, function ($query, $filter)
                {
                    $query->where($filter);
                })
                ->when($arr_tanggal, function ($query, $arr_tanggal)
                {
                    $query->whereBetween('realisasi_danas.tanggal', $arr_tanggal);
                });
            }
        ])
        ->get();
    }

    public function openTabKeuangan()
    {
        $this->control_tabs = [
            'keuangan' => true,
            'kwitansi' => false,
            'kas_besar' => false,
        ];
    }
    public function openTabKwitansi()
    {
        $this->control_tabs = [
            'keuangan' => false,
            'kwitansi' => true,
            'kas_besar' => false,
        ];
        $this->setListKwitansi();
    }

    public function resetInput()
    {
        $this->reset(['paket_id', 'filter_tanggal']);
        $this->dispatchBrowserEvent('select2:reset', ['selector' => '.select-paket']);
    }

    public function setPaket($value)
    {
        $this->paket_id = $value;
    }

    public function setTanggal($value)
    {
        $this->filter_tanggal = $value;
    }

    public function exportToExcel()
    {
        $tanggal = 'ALL';
        $code = 'ALL';

        $filter = [];
        $arr_tanggal = [];

        if ($this->paket_id) {
            $paket = MsSubCode::findOrFail($this->paket_id);
            $code = $paket->code.' - '.$paket->nama;
            $filter['paket_id'] = $this->paket_id;
        }
        if($this->filter_tanggal) {
            $tanggal = date('F Y', strtotime($this->filter_tanggal));
            $start_date = date('Y-m-1 00:00:00', strtotime($this->filter_tanggal));
            $end_date = date('Y-m-t 00:00:00', strtotime($this->filter_tanggal));
            $arr_tanggal = [$start_date, $end_date];
        }
        $data['jurnal'] = [
            'code' => $code,
            'tanggal' => $tanggal,
        ];

        $data['list_items'] = Kwitansi::query()
        ->with([
            'realisasi_danas' => function ($query) use($filter, $arr_tanggal)
            {
                $query->with(['material_pengajuans.material.ms_satuan', 'pengajuan.item:id,sub_divisi_id,nama'])
                ->leftJoin('pengajuan_danas as pd', 'pd.id', 'realisasi_danas.pengajuan_dana_id')
                ->when($filter, function ($query, $filter)
                {
                    $query->where($filter);
                })
                ->when($arr_tanggal, function ($query, $arr_tanggal)
                {
                    $query->whereBetween('realisasi_danas.tanggal', $arr_tanggal);
                });
            }
        ])
        ->get();
        return Excel::download(new JurnalKwitansiExport($data), 'jurnal-kwitansi.xlsx');
    }
}
