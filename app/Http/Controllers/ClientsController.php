<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\WorkerClient;
use App\Models\User;

use Carbon\Carbon;

class ClientsController extends Controller
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

        $clients_id = [];
        if(!empty($request->w)){
            $clients_id = $request->w;
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

        $users['clients'] = User::where('role', 'client')->get()->sortBy('name');

        WorkerClient::where('hours',0)->delete();

        $WorkerClient = WorkerClient::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ]);
        $AllWorkerClient = $WorkerClient->get()->unique('client_id');
        if(!empty($clients_id) && !empty($WorkerClient)){
            $WorkerClient = $WorkerClient->whereIn("client_id", $clients_id);
        }
        $WorkerClient = $WorkerClient->get();

        return view('clients')->with([
			'clients_id'=>$clients_id,
			'date_or_period'=>$date_or_period,
			'WorkerClient'=>$WorkerClient,
			'AllWorkerClient'=>$AllWorkerClient,
			'selectCountDays'=>$selectCountDays,
			'users'=>$users,
		]);
    }

    public function temp(){
        return view('clients-old');
    }

    /**
     * Add New Client
     *
     */
    public function addNewClient(Request $request){

        $lastUrlForReditect = $request->lastUrl;

        $new_user = new User;
        $new_user->name = $request->name;
        $new_user->email = $request->email;
        $new_user->address = $request->address;
        $new_user->phone = $request->phone;
        $new_user->role = 'client';
        $new_user->password = Hash::make($request->password);
        $new_user->save();

        return redirect($lastUrlForReditect)->with('status', 'Добавлен новый клиент: <b>'.$request->name.'</b>');

    }

}
