<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class xlsExport implements FromView
{
    public function view(): View
    {
        return view('exports.xls', [
            'a' => 112,
        ]);
    }
}
