<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalHarianExport implements FromView, ShouldAutoSize
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('layouts.excel.jurnal-harian-export', [
            'list_items' => $this->data['list_items'],
            'jurnal' => $this->data['jurnal'],
        ]);
    }
}