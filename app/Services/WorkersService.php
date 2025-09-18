<?php

namespace App\Services;

use App\Exports\WorkersXlsExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WorkersService
{
    public function exportToXls(array $dateOrPeriod): BinaryFileResponse
    {
        $selectCountDays = 1;

        if (!empty($dateOrPeriod[1])) {
            $date1 = date_create($dateOrPeriod[0]);
            $date2 = date_create($dateOrPeriod[1]);
            $diff = date_diff($date1, $date2);
            $selectCountDays = $diff->format('%a') + 1;
        }

        $workers = User::query()
            ->where('role', User::ROLE_WORKER)
            ->active()
            ->with([
                'clientHours' => function ($query) use ($dateOrPeriod) {
                    $query->whereBetween(
                        'created_at',
                        [$dateOrPeriod[0], $dateOrPeriod[1]],
                    );
                },
                'clientHours.clientRelation',
                'clients',
                'salary',
                'clientHoursByClient' => function ($query) use ($dateOrPeriod) {
                    $query->whereBetween(
                        'created_at',
                        [$dateOrPeriod[0], $dateOrPeriod[1]],
                    );
                },
            ])
            ->whereHas('clientHours', function ($query) use ($dateOrPeriod) {
                $query->whereBetween(
                    'created_at',
                    [$dateOrPeriod[0], $dateOrPeriod[1]],
                );
            })
            ->withSum([
                'clientHours' => function ($query) use ($dateOrPeriod) {
                    $query->whereBetween(
                        'created_at',
                        [$dateOrPeriod[0], $dateOrPeriod[1]],
                    );
                },
            ], 'hours');

        if ($selectCountDays === 1) {
            $workers = $workers->orderBy('name', 'asc');
        } else {
            $workers = $workers->orderBy('client_hours_sum_hours', 'asc');
        }

        return Excel::download(
            new WorkersXlsExport($dateOrPeriod, $workers->get()),
            'workers_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }
}
