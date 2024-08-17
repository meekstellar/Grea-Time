<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use App\Models\WorkerClient;
use App\Models\ClientsFees;
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

        if(auth()->user()->role != 'worker'){

            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                // Add some items to the menu...
                $event->menu->add([
                    'text' => 'Сотрудники',
                    'url' => 'workers',
                    'icon' => 'nav-icon fas fa-user-tie',
                ],
                [
                    'text' => 'Клиенты',
                    'url' => 'clients',
                    'icon' => 'nav-icon fas fa-user-secret',
                ]);
            });

        }

        if(auth()->user()->role == 'worker'){
            return redirect()->route('worker');
        }

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

        $users['clients'] = User::where('role', 'client')->where('active', 1)->get()->sortBy('name');

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

    /**
     * Add New Client
     *
     */
    public function addNewClient(Request $request){

        $lastUrlForReditect = $request->lastUrl;

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        //$user->phone = $request->phone;
        $user->role = 'client';
        if($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users','public');
        }

        if(!empty($request->password)){
            $request->password = 'password';
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect($lastUrlForReditect)->with('status', 'Добавлен новый клиент: <b>'.$request->name.'</b>');

    }

    /**
     * Edit Client
     *
     */
    public function editClient(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $lastUrlForReditect = $request->lastUrl;

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if(!empty($request->delete_photo)){
            $user->image = '';
        }

        if($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users','public');
        }

        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }

        $user->save();


        // delete user
        if(!empty($request->delete_user)){
            $user->active = 0;
            $user->save();
            return redirect($lastUrlForReditect)->with('status', 'Клиент <b>'.$user->name.'</b> были удален.');
        } else {
            return redirect($lastUrlForReditect)->with('status', 'Данные клиента <b>'.$request->name.'</b> были обновлены.');
        }

    }

    /**
     * Set Fee For Client
     *
     */
    public function setFee(Request $request){
        $ClientsFees = ClientsFees::where('client_id', $request->client_id)
            ->where('year',$request->year)
            ->where('month',$request->month)
            ->first();
        if(!is_null($ClientsFees)){
            $ClientsFees->fee = $request->fee;
            $ClientsFees->save();
        } else {
            $ClientsFees = new ClientsFees;
            $ClientsFees->client_id = $request->client_id;
            $ClientsFees->year = $request->year;
            $ClientsFees->month = $request->month;
            $ClientsFees->fee = $request->fee;
            $ClientsFees->save();
        }

        $user = User::where('id',$request->client_id)->first();
        return response()->json(['status' => true, 'messages' => 'Гонорар установлен для клиента '.$user->name.$ClientsFees->id.'']);
    }

}
