<?php

namespace App\Http\Livewire\Keuangan;

use Livewire\Component;
use App\Models\{
    Keuangan\ItemJurnalHarian,
    Keuangan\ItemJurnalHarianMasuk,
    
    Master\MsSubCode,
};
use App\Exports\{
    JurnalHarianExport,
    Keuangan\JurnalHarianAllExport,
};
use Maatwebsite\Excel\Facades\Excel;
use DB;

class LvJurnalHarian extends Component
{
    protected $listeners = [
        'evSetPaket' => 'setPaket',
        'evSetTanggal' => 'setTanggal',
        'evSetInputTanggal' => 'setInputTanggal',
    ];
    
    public $paket_id;
    public $total_kas_masuk = 0;
    public $total_kas_keluar = 0;
    public $item_id;
    public $item_nama;
    public $item_jumlah;
    public $item_harga_satuan;
    public $jurnal_masuk_id;
    public $jurnal_masuk_sumber;
    public $jurnal_masuk_jumlah;
    public $input_tanggal;
    
    public $filter_data = [];
    public $filter_between = [];
    public $filter_tanggal;
    public $previous_item;
    
    public function render()
    {
        $data['pakets'] = MsSubCode::all();
        
        $data['item_jurnal_masuks'] = ItemJurnalHarianMasuk::query()
        ->when($this->filter_between, function ($query, $filter_data) {
            return $query->whereBetween('tanggal', $filter_data['tanggal']);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        $data['item_jurnals'] = ItemJurnalHarian::query()
        ->with('paket')
        ->when($this->filter_data, function ($query, $filter_data) {
            return $query->where($filter_data);
        })
        ->when($this->filter_between, function ($query, $filter_data) {
            return $query->whereBetween('tanggal', $filter_data['tanggal']);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        
        return view('livewire.keuangan.lv-jurnal-harian')
        ->with($data)
        ->layout('layouts.dashboard.main');
    }
    
    public function addJurnalMasuk()
    {
        $this->validate([
            'jurnal_masuk_sumber' => 'required|string',
            'jurnal_masuk_jumlah' => 'required|integer',
            'input_tanggal' => 'required|string',
        ]);
        
        $date_now = date('Y-m-d', strtotime($this->input_tanggal));
        
        $insert = ItemJurnalHarianMasuk::create([
            'sumber' => $this->jurnal_masuk_sumber,
            'jumlah' => $this->jurnal_masuk_jumlah,
            'tanggal' => $date_now,
        ]);
        $this->resetInput();
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }
    
    public function addItemJurnal()
    {
        $this->validate([
            'paket_id' => 'required|integer',
            'item_nama' => 'required|string',
            'item_jumlah' => 'required|integer',
            'item_harga_satuan' => 'required|integer',
            'input_tanggal' => 'required|string',
        ]);
        
        $date_now = date('Y-m-d', strtotime($this->input_tanggal));
        
        $insert = ItemJurnalHarian::create([
            'paket_id' => $this->paket_id,
            'nama' => $this->item_nama,
            'jumlah' => $this->item_jumlah,
            'harga_satuan' => $this->item_harga_satuan,
            'total_harga' => $this->item_jumlah*$this->item_harga_satuan,
            'tanggal' => $date_now,
        ]);
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully adding data.']);
    }
    
    public function setPaket($value)
    {
        $this->paket_id = $value;
    }
    
    public function setTanggal($value)
    {
        $this->filter_tanggal = $value;
    }
    
    public function setInputTanggal($value)
    {
        $this->input_tanggal = $value;
    }
    
    public function resetInput()
    {
        $this->reset([
            'paket_id', 
            'item_id', 
            'item_nama', 
            'item_jumlah', 
            'item_harga_satuan', 
            'jurnal_masuk_sumber',
            'jurnal_masuk_jumlah',
            'input_tanggal',
            'filter_data', 
            'filter_between', 
            'filter_tanggal',
            'total_kas_masuk',
            'total_kas_keluar',
            'previous_item',
        ]);
        $this->dispatchBrowserEvent('select2:reset', ['selector' => '.select-paket']);
    }
    
    public function setFilter()
    {
        $filter = [];
        if($this->filter_tanggal) {
            $start_date = date('Y-m-1 00:00:00', strtotime($this->filter_tanggal));
            $end_date = date('Y-m-t 00:00:00', strtotime($this->filter_tanggal));
            $this->filter_between['tanggal'] = [$start_date, $end_date];
            
            $filter_tanggal_then = date('Y-m-1 00:00:00', strtotime('-1 months', strtotime($this->filter_tanggal)));
            $end_date_then = date('Y-m-t 00:00:00', strtotime($filter_tanggal_then));
            
            $filter_between_then['tanggal'] = [$filter_tanggal_then, $end_date_then];
            
            $query_total_1 = ItemJurnalHarianMasuk::query()
            ->selectRaw('SUM(jumlah) as total')
            ->whereBetween('tanggal', $filter_between_then)
            ->pluck('total')
            ->first();
            
            $query_total_2 = ItemJurnalHarian::query()
            ->selectRaw('SUM(total_harga) as total')
            ->whereBetween('tanggal', $filter_between_then)
            ->pluck('total')
            ->first();
            
            $akumulasi_masuk = $query_total_1;
            $akumulasi_keluar = $query_total_2;
            $saldo = $akumulasi_masuk - $akumulasi_keluar;
            
            $this->total_kas_masuk = $akumulasi_masuk;
            $this->total_kas_keluar = $akumulasi_keluar;
            $this->previous_item = ['month' => date('F', strtotime($filter_tanggal_then)), 'total_in' => $akumulasi_masuk, 'total_out' => $akumulasi_keluar, 'saldo' => $saldo];
        }
        if($this->paket_id) {
            $filter['paket_id'] = $this->paket_id;
        }
        $this->filter_data = $filter;
    }
    
    public function exportToExcel()
    {
        $tanggal = 'ALL';
        $code = 'ALL';
        if ($this->paket_id) {
            $paket = MsSubCode::findOrFail($this->paket_id);
            $code = $paket->code.' - '.$paket->nama;
        }
        if($this->filter_tanggal) {
            $tanggal = date('F Y', strtotime($this->filter_tanggal));
        }
        $data['jurnal'] = [
            'code' => $code,
            'tanggal' => $tanggal,
        ];
        
        $data['list_items'] = ItemJurnalHarian::query()
        ->with('paket')
        ->when($this->filter_data, function ($query, $filter_data) {
            return $query->where($filter_data);
        })
        ->when($this->filter_between, function ($query, $filter_data) {
            return $query->whereBetween('tanggal', $filter_data['tanggal']);
        })
        ->orderBy('created_at', 'desc')
        ->get();
        return Excel::download(new JurnalHarianExport($data), 'jurnal-harian.xlsx');
    }
    
    public function exportToExcelAll()
    {
        $tanggal = '-';
        $divisi = '-';
        $code = '-';
        $akumulasi_masuk = 0;
        $akumulasi_keluar = 0;
        $saldo = 0;
        $data['previous_item'] = null;
        
        if ($this->paket_id) {
            $paket = MsSubCode::query()
            ->with('divisi')
            ->where('id', $this->paket_id)
            ->firstOrFail();
            
            $divisi = $paket->divisi->nama;
            $code = $paket->code;
        }
        if($this->filter_tanggal) {
            $tanggal = date('F Y', strtotime($this->filter_tanggal));
            
            $filter_tanggal_then = date('Y-m-1 00:00:00', strtotime('-1 months', strtotime($this->filter_tanggal)));
            $end_date_then = date('Y-m-t 00:00:00', strtotime($filter_tanggal_then));
            
            $filter_between_then['tanggal'] = [$filter_tanggal_then, $end_date_then];
            
            $query_total_1 = ItemJurnalHarianMasuk::query()
            ->selectRaw('SUM(jumlah) as total')
            ->whereBetween('tanggal', $filter_between_then)
            ->pluck('total')
            ->first();
            
            $query_total_2 = ItemJurnalHarian::query()
            ->selectRaw('SUM(total_harga) as total')
            ->whereBetween('tanggal', $filter_between_then)
            ->pluck('total')
            ->first();
            
            $akumulasi_masuk = $query_total_1;
            $akumulasi_keluar = $query_total_2;
            $saldo = $akumulasi_masuk - $akumulasi_keluar;
            $data['previous_item'] = ['month' => date('F', strtotime($filter_tanggal_then)), 'total_in' => $akumulasi_masuk, 'total_out' => $akumulasi_keluar];
        }
        
        
        $query_1 = ItemJurnalHarianMasuk::query()
        ->select('id' , 'sumber as description', 'jumlah as total', 'tanggal')
        ->selectRaw('"masuk" as type');
        
        $query_2 = ItemJurnalHarian::query()
        ->select('id' , 'nama as description', 'total_harga as total', 'tanggal')
        ->selectRaw('"keluar" as type')
        ->unionAll($query_1)
        ->when($this->filter_data, function ($query, $filter_data) {
            return $query->where($filter_data);
        });
        
        $main_query = DB::table(DB::raw(" ({$query_2->toSql()}) as tab"))
        ->mergeBindings($query_2->getQuery())
        ->when($this->filter_between, function ($query, $filter_data) {
            return $query->whereBetween('tanggal', $filter_data['tanggal']);
        })
        ->select('*')
        ->orderBy('tanggal')
        ->get();
        
        $data['list_items'] = $main_query;
        
        $data['total'] = ['akumulasi_masuk' => $akumulasi_masuk, 'akumulasi_keluar' => $akumulasi_keluar, 'saldo' => $saldo];
        $data['jurnal'] = ['divisi' => $divisi, 'code' => $code, 'tanggal' => $tanggal];
        return Excel::download(new JurnalHarianAllExport($data), 'jurnal-harian-all.xlsx');
    }
    
    public function setUraian($id)
    {
        $uraian = ItemJurnalHarian::findOrFail($id);
        $this->paket_id = $uraian->paket_id;
        $this->item_id = $uraian->id;
        $this->item_nama = $uraian->nama;
        $this->item_jumlah = $uraian->jumlah;
        $this->item_harga_satuan = $uraian->harga_satuan;
        $this->dispatchBrowserEvent('select2:set', ['selector' => '#select_paket_ed', 'value' => $uraian->paket_id]);
    }
    
    public function setJurnalMasuk($id)
    {
        $jurnal_masuk = ItemJurnalHarianMasuk::findOrFail($id);
        $this->jurnal_masuk_id = $jurnal_masuk->id;
        $this->jurnal_masuk_sumber = $jurnal_masuk->sumber;
        $this->jurnal_masuk_jumlah = $jurnal_masuk->jumlah;
    }
    
    public function updateUraian()
    {
        $this->validate([
            'paket_id' => 'required|integer',
            'item_nama' => 'required|string',
            'item_jumlah' => 'required|integer',
            'item_harga_satuan' => 'required|integer',
        ]);
        
        $update = ItemJurnalHarian::query()
        ->where('id', $this->item_id)
        ->update([
            'paket_id' => $this->paket_id,
            'nama' => $this->item_nama,
            'jumlah' => $this->item_jumlah,
            'harga_satuan' => $this->item_harga_satuan,
            'total_harga' => $this->item_jumlah*$this->item_harga_satuan,
        ]);
        
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully updating data.']);
    }
    
    public function updateJurnalMasuk()
    {
        $this->validate([
            'jurnal_masuk_sumber' => 'required|string',
            'jurnal_masuk_jumlah' => 'required|integer',
        ]);
        
        $update = ItemJurnalHarianMasuk::query()
        ->where('id', $this->jurnal_masuk_id)
        ->update([
            'sumber' => $this->jurnal_masuk_sumber,
            'jumlah' => $this->jurnal_masuk_jumlah,
        ]);
        
        $this->resetInput();
        
        return $this->dispatchBrowserEvent('notification:success', ['title' => 'Success!', 'message' => 'Successfully updating data.']);
    }
    
    public function delete($id)
    {
        $item_jurnal = ItemJurnalHarian::findOrFail($id);
        $item_jurnal->delete();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
    
    public function deleteJurnalMasuk($id)
    {
        $item_jurnal = ItemJurnalHarianMasuk::findOrFail($id);
        $item_jurnal->delete();
        return ['status_code' => 200, 'message' => 'Data has been deleted.'];
    }
}
