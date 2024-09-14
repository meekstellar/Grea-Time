<?php

namespace  App\Services;

use App\Models\WorkerClientHours;
use App\Models\User;

use Carbon\Carbon;

class ClientsService
{

    public function WorkerClientHours($date_or_period, $w, $template)
    {
        $clients_id = (!empty($w) ? $w : []);

        if(!empty($date_or_period)){
            $date_or_period = explode("--", $date_or_period);
        } else {
            $date_or_period[] = date("d-m-Y", time());
        }

        $selectCountDays = 1;
        if(!empty($date_or_period[1])){
            $date1 = date_create($date_or_period[0]);
            $date2 = date_create($date_or_period[1]);
            $diff = date_diff($date1, $date2);
            $selectCountDays = $diff->format('%a')+1;
        }

        $date_or_period_with_secounds[] = new Carbon($date_or_period[0]);
        $date_or_period_with_secounds[] = new Carbon((!empty($date_or_period[1]) ? $date_or_period[1] : $date_or_period[0])); // Final date
        $date_or_period_with_secounds[1]->addHour(23)->addMinutes(59)->addSeconds(59);
        WorkerClientHours::where('hours',0)->delete();
        $WorkerClientHours = WorkerClientHours::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ]);
        //$AllWorkerClientHours = $WorkerClientHours->get()->unique('client_id');
        if(!empty($clients_id) && !empty($WorkerClientHours)){
            $WorkerClientHours = $WorkerClientHours->whereIn("client_id", $clients_id);
        }
        $WorkerClientHours = $WorkerClientHours->get();

        $users['clients'] = User::where('role', 'client')->where('active', 1)->get()->sortBy('name');
        $url_w = '';
        if(!empty($w) && !empty($users['clients'])){
            foreach($users['clients'] as $client){
                if(!empty($w) && in_array($client->id,$w)){
                    $url_w .= '&w[]='.$client->id;
                }
            }
        }

        return view($template)->with([
            'clients_id'=>$clients_id,
            'date_or_period'=>$date_or_period,
            'selectCountDays'=>$selectCountDays,
            'WorkerClientHours'=>$WorkerClientHours,
            'users'=>$users,
            'url_w'=>$url_w,
            'currency'=>'₽',
        ]);

    }

}
