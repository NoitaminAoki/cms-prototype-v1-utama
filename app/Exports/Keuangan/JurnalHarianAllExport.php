<?php

namespace App\Exports\Keuangan;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class JurnalHarianAllExport implements FromView, ShouldAutoSize
{
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('layouts.excel.keuangan.jurnal-harian-all-export', [
            'list_items' => $this->data['list_items'],
            'total' => $this->data['total'],
            'previous_item' => $this->data['previous_item'],
            'jurnal' => $this->data['jurnal'],
        ]);
    }
}