<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\WorkerClient;
use App\Models\User;

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

        /*if(auth()->user()->role != 'manager'){
            return redirect()->route('worker');
        }*/

        $workers_id = [];
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

        $users['workers'] = User::where('role', 'worker')->get()->sortBy('name');
        $users['clients'] = User::where('role', 'client')->get()->sortBy('name');

        WorkerClient::where('hours',0)->delete();

        $WorkerClient = WorkerClient::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ]);
        $AllWorkerClient = $WorkerClient->get()->unique('worker_id');
        if(!empty($workers_id) && !empty($WorkerClient)){
            $WorkerClient = $WorkerClient->whereIn("worker_id", $workers_id);
        }
        $WorkerClient = $WorkerClient->get();

        return view('workers')->with([
			'workers_id'=>$workers_id,
			'date_or_period'=>$date_or_period,
			'WorkerClient'=>$WorkerClient,
			'AllWorkerClient'=>$AllWorkerClient,
			'selectCountDays'=>$selectCountDays,
			'users'=>$users,
		]);

    }

    /**
     * Worker
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function worker(Request $request)
    {
        return view('worker');
    }

    /**
     * Change Client’s Hours
     *
     */
    public function changeClientsHours(Request $request){
        $wc = WorkerClient::find($request->wc_id);
        $wc->hours = $request->newHours;
        $wc->save();
        return response()->json(['status' => true, 'messages' => 'Установлены часы работы для <br><b>'.$wc->client()->name.'</b>']);
    }

    /**
     * Add Client’s hours
     *
     */
    public function addClientHours(Request $request){

        $lastUrlForReditect = $request->lastUrl;
        $created_at = new Carbon($request->created_at);
        $created_at->addHour(18);

        $wc = new WorkerClient;
        $wc->worker_id = $request->worker_id;
        $wc->client_id = $request->client_id;
        $wc->hours = $request->hours;
        $wc->created_at = $created_at;
        $wc->updated_at = $created_at;
        $wc->save();

        return redirect($lastUrlForReditect)->with('status', 'Установлены часы работы для <br><b>'.$wc->client()->name.'</b>');

    }

    /**
     * Add New Worker
     *
     */
    public function addNewWorker(Request $request){

        $lastUrlForReditect = $request->lastUrl;

        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->position = $request->position;
        $new_user->phone = $request->phone;
        $new_user->role = 'worker';
        $new_user->image = 'vendor/adminlte/dist/img/no-usericon.svg';
        $new_user->password = Hash::make($request->password);
        $new_user->save();

        return redirect($lastUrlForReditect)->with('status', 'Добавлен новый сотрудник: <b>'.$request->name.'</b>');

    }

}
