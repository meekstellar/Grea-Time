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
        \App\Models\WorkerClient::factory(3000)->create();

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
                    \App\Models\WorkerClient::where('client_id',$user->id)->delete();
                    $user->delete();
                }
            }
            $k++;
        }

    }
}
