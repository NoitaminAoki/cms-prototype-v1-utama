<?php

namespace App\Exports\Keuangan;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalKwitansiExport implements FromView, ShouldAutoSize
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('layouts.excel.keuangan.jurnal-kwitansi-export', [
            'list_items' => $this->data['list_items'],
            'jurnal' => $this->data['jurnal'],
        ]);
    }
}