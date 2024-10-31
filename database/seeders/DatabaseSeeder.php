<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ClientsFees;

use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(40)->create();
        \App\Models\WorkerClientHours::factory(3000)->create();

        // select random client

        $images = [
            [
                'name' => 'PR Port Authority',
                'image' => 'vendor/adminlte/dist/img/temp/DP_World_Prince_Rupert_Port_seeking_to_double_capacity_through_t.jpg',
            ],
            [
                'name' => 'YAGA',
                'image' => 'vendor/adminlte/dist/img/temp/yaga.webp',
            ],
            [
                'name' => "O'BRIEN ROAD & BRIDGE MAINTENANCE LTD",
                'image' => 'vendor/adminlte/dist/img/temp/orbm-new-1.png',
            ],
            [
                'name' => 'City West',
                'image' => 'vendor/adminlte/dist/img/temp/city-west.png',
            ],
            [
                'name' => 'Cow Bay Marina',
                'image' => 'vendor/adminlte/dist/img/temp/slide_two.png',
            ],
            [
                'name' => 'Trigon',
                'image' => 'vendor/adminlte/dist/img/temp/Trigon_Pacific_Terminals_Limited_Prince_Rupert_s_Largest_Marine.jpg',
            ],
            [
                'name' => 'Bandstra Transportation System LTD',
                'image' => 'vendor/adminlte/dist/img/temp/bandstra.png',
            ],
            [
                'name' => 'Bridgeview Marine',
                'image' => 'vendor/adminlte/dist/img/temp/bridgeview-marine-logo.svg',
            ],
            [
                'name' => 'Digby Island Ferry',
                'image' => 'vendor/adminlte/dist/img/temp/YPR_Logo.png',
            ],
        ];

        $fees = [280000, 300000, 320000, 350000];
        $k = 0;
        $users = \App\Models\User::where('role','client')->get();
        foreach($users->unique('name') as $user){
            if(!empty($images[$k])){

                $user->name = $images[$k]['name'];
                $user->image = $images[$k]['image'];
                $user->save();

                $now = Carbon::now();

                $ClientsFees = new ClientsFees;
                $ClientsFees->client_id = $user->id;
                $ClientsFees->year = $now->year;
                $ClientsFees->month = $now->month;
                $ClientsFees->fee = $fees[rand(0,count($fees)-1)];
                $ClientsFees->save();

                $ClientsFees = new ClientsFees;
                $ClientsFees->client_id = $user->id;
                $ClientsFees->year = $now->year;
                $ClientsFees->month = $now->month-1;
                $ClientsFees->fee = $fees[rand(0,count($fees)-1)];

                $ClientsFees->save();

            } else {
                if($k>=count($images)){
                    \App\Models\WorkerClientHours::where('client_id',$user->id)->delete();
                    $user->delete();
                }
            }
            $k++;
        }

        $workers_id = \App\Models\User::where('role','worker')->pluck('id')->toArray();

        $clients_id = \App\Models\User::where('role','client')->pluck('id')->toArray();

        $salaries = [150000, 80000, 120000, 100000];

        // Connect wokrers with clients (all with all)
        foreach ($workers_id as $worker_id => $worker_value) {
            foreach ($clients_id as $client_id => $client_value) {
                $wc = new \App\Models\WorkerClient;
                $wc->worker_id = $worker_value;
                $wc->client_id = $client_value;
                $wc->save();
            }
            $ws = new \App\Models\WorkersSalary;
            $ws->worker_id = $worker_value;
            $ws->year = date("Y", time());
            $ws->month = date("m", time());
            $ws->salary = $salaries[rand(0,count($salaries)-1)];
            $ws->save();
        }

    }
}
