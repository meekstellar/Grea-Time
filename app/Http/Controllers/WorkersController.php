<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\WorkerClient;

use Carbon\Carbon;

class WorkersController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        $workers_id[] = [];
        if(!empty($request->w)){
            $workers_id = $request->w;
        }

        $date_or_period[] = date("d-m-Y", time());
        $selectCountDays = 1;
        if(!empty($request->date_or_period)){
            $date_or_period = explode("--", $request->date_or_period);
        }

        if(!empty($date_or_period[1])){

            $date1 = date_create($date_or_period[0]);
            $date2 = date_create($date_or_period[1]);

            $diff = date_diff($date1, $date2);
            $selectCountDays = $diff->format('%a')+1;
        }

        $date_or_period_with_secounds[] = new Carbon($date_or_period[0]);
        $date_or_period_with_secounds[] = new Carbon((!empty($date_or_period[1]) ? $date_or_period[1] : $date_or_period[0])); // Final date
        $date_or_period_with_secounds[1]->addHour(23)->addMinutes(59)->addSeconds(59);

        //$users['workers'] = User::where('role', 'worker')->get();
        //$users['clients'] = User::where('role', 'client')->get();

        $WorkerClient = WorkerClient::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ]);
        if(!empty($workers_id) && !empty($WorkerClient)){
            //$WorkerClient = $WorkerClient->whereIn("worker_id", $workers_id);
        }
        $WorkerClient = $WorkerClient->get();
        //$WorkerClient = WorkerClient::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ])->pluck('worker_id')->toArray();

        //dd($WorkerClient->unique('worker_id'), $WorkerClient);
        //dd($WorkerClient->unique('worker_id'));

        /*foreach($WorkerClient as $WC){
            dd($WC->worker()->name, $WC->client()->name);
        }*/
        return view('workers')->with([
			'workers_id'=>$workers_id,
			'date_or_period'=>$date_or_period,
			'WorkerClient'=>$WorkerClient,
			'selectCountDays'=>$selectCountDays,
		]);

    }
}
