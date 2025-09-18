<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class WorkersXlsExport implements FromView
{
    public function __construct(
        public array $dateOrPeriod,
        public Collection $workers
    ) {}

    public function view(): View
    {
        $dateOrPeriod[] = $this->dateOrPeriod[0]->format('d.m.Y');
        $dateOrPeriod[] = $this->dateOrPeriod[1]->format('d.m.Y');

        return view('exports.workers_export', [
            'workers' => $this->workers,
            'dateOrPeriod' => $dateOrPeriod,
        ]);
    }
}
