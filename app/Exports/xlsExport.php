<?php

namespace App\Exports;

use App\Invoice;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use App\Services\ClientsService;

use App\Models\User;

class xlsExport implements FromView
{
	public function __construct($date_or_period, $w, $service)
	{
		$this->date_or_period = $date_or_period;
		$this->w = $w;
		$this->service = $service;
	}

    public function view(): View
    {
        return $this->service->WorkerClientHours($this->date_or_period, $this->w, 'exports.export');
    }
}
