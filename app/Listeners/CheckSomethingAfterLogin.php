<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Support\Facades\DB;

class CheckSomethingAfterLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event): void
    {

        // Перевіряємо зарплату для всіх працівників за поточний місяць
        $check_workers_salary = DB::table('workers_salary')
            ->where('year', now()->year)
            ->where('month', now()->month)
            ->exists();  // Перевіряємо, чи є вже записи для поточного місяця

        if (!$check_workers_salary) {
            // Виконайте вашу дію, якщо перевірка не пройдена
            DB::table('workers_salary')
                ->distinct()
                ->select('worker_id')
                ->orderBy('worker_id')  // Вказуємо порядок сортування (наприклад, за worker_id)
                ->chunk(100, function ($workers) {
                    foreach ($workers as $worker) {
                        $this->checkAndAssignSalary($worker->worker_id);
                    }
                });
        }

        // Перевіряємо гонорар' для всіх працівників за поточний місяць
        $check_clients_fees = DB::table('clients_fees')
            ->where('year', now()->year)
            ->where('month', now()->month)
            ->exists();  // Перевіряємо, чи є вже записи для поточного місяця

        if (!$check_clients_fees) {
            // Виконайте вашу дію, якщо перевірка не пройдена
            DB::table('clients_fees')
                ->distinct()
                ->select('client_id')
                ->orderBy('client_id')  // Вказуємо порядок сортування (наприклад, за client_id)
                ->chunk(100, function ($clients) {
                    foreach ($clients as $client) {
                        $this->checkAndAssignFees($client->client_id);
                    }
                });
        }

    }

    function checkAndAssignSalary($workerId) {
        // Отримуємо поточний місяць і рік
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Перевіряємо, чи є зарплата за поточний місяць
        $exists = DB::table('workers_salary')
            ->where('worker_id', $workerId)
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->exists();

        if (!$exists) {
            // Визначаємо попередній місяць і рік
            $previousMonth = $currentMonth - 1;
            $previousYear = $currentYear;

            if ($previousMonth == 0) {
                $previousMonth = 12;
                $previousYear--;
            }

            // Отримуємо зарплату за попередній місяць
            $previousSalary = DB::table('workers_salary')
                ->where('worker_id', $workerId)
                ->where('year', $previousYear)
                ->where('month', $previousMonth)
                ->value('salary');

            // Якщо є дані з попереднього місяця, додаємо новий запис
            if ($previousSalary !== null) {
                DB::table('workers_salary')->insert([
                    'worker_id' => $workerId,
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'salary' => $previousSalary,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    function checkAndAssignFees($clientId) {
        // Отримуємо поточний місяць і рік
        $currentYear = now()->year;
        $currentMonth = now()->month;

        // Перевіряємо, чи є гонрар за поточний місяць
        $exists = DB::table('clients_fees')
            ->where('client_id', $clientId)
            ->where('year', $currentYear)
            ->where('month', $currentMonth)
            ->exists();

        if (!$exists) {
            // Визначаємо попередній місяць і рік
            $previousMonth = $currentMonth - 1;
            $previousYear = $currentYear;

            if ($previousMonth == 0) {
                $previousMonth = 12;
                $previousYear--;
            }

            // Отримуємо гонорар за попередній місяць
            $previousFee = DB::table('clients_fees')
                ->where('client_id', $clientId)
                ->where('year', $previousYear)
                ->where('month', $previousMonth)
                ->value('fee');

            // Якщо є дані з попереднього місяця, додаємо новий запис
            if ($previousFee !== null) {
                DB::table('clients_fees')->insert([
                    'client_id' => $clientId,
                    'year' => $currentYear,
                    'month' => $currentMonth,
                    'fee' => $previousFee,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

}
