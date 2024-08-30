<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use App\Models\WorkerClient ;
use App\Models\WorkerClientHours;
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

        if(auth()->user()->role != 'manager'){
            return redirect()->route('worker');
        }

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

        $users['workers'] = User::where('role', 'worker')->where('active', 1)->get()->sortBy('name')->keyBy('id');
        $users['clients'] = User::where('role', 'client')->where('active', 1)->get()->sortBy('name')->keyBy('id');

        WorkerClientHours::where('hours',0)->delete();

        $WorkerClientHours = WorkerClientHours::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ]);
        //$AllWorkerClientHours = $WorkerClientHours->get()->unique('worker_id');
        if(!empty($workers_id) && !empty($WorkerClientHours)){
            $WorkerClientHours = $WorkerClientHours->whereIn("worker_id", $workers_id);
        }
        $WorkerClientHours = $WorkerClientHours->get();

        return view('workers')->with([
			'workers_id'=>$workers_id,
			'date_or_period'=>$date_or_period,
			'WorkerClientHours'=>$WorkerClientHours,
			//'AllWorkerClientHours'=>$AllWorkerClientHours,
			'selectCountDays'=>$selectCountDays,
			'users'=>$users,
			'worker_ids__wrote_time'=>[],
		]);

    }

    /**
     * Worker
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function worker(Request $request)
    {
        if(!Auth::user()->active){
            Auth::logout();
            return redirect('/')
                ->with('message', 'Доступ закрыт');
        }
        $date_or_period_with_secounds[0] = new Carbon(date('d-m-Y', time()));
        $date_or_period_with_secounds[1] = new Carbon(date('d-m-Y', time())); // Final date
        $date_or_period_with_secounds[1]->addHour(23)->addMinutes(59)->addSeconds(59);

        $WorkerClientHoursArray = WorkerClientHours::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ])
            ->where("worker_id", auth()->user()->id)->get()->keyBy('client_id')->toArray();

        $user_ids = Auth::user()->get_connect_clients_id();

        $users['clients'] = User::WhereIn('id',$user_ids)->where('role', 'client')->where('active', 1)->get()->sortBy('name');

        return view('worker')->with([
			'WorkerClientHoursArray'=>$WorkerClientHoursArray,
			'users'=>$users,
		]);
    }

    /**
     * Save Worker data
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function saveWorker(Request $request)
    {

        $date_or_period_with_secounds[0] = new Carbon(date('d-m-Y', time()));
        $date_or_period_with_secounds[1] = new Carbon(date('d-m-Y', time())); // Final date
        $date_or_period_with_secounds[1]->addHour(23)->addMinutes(59)->addSeconds(59);

        foreach($request->clients as $client_id=>$hours){
            $data = [
                'worker_id' => auth()->user()->id,
                'client_id' => $client_id,
                'hours' => $hours,
            ];

            $WorkerClientHours = WorkerClientHours::whereBetween("created_at", [ $date_or_period_with_secounds[0], $date_or_period_with_secounds[1] ])
                ->where('worker_id',auth()->user()->id)
                ->where("client_id", $client_id)
                ->first();

            if(!empty($WorkerClientHours->id)){
                $WorkerClientHours->update($data);
            } else {
                $WorkerClientHours = new WorkerClientHours();
                $WorkerClientHours->fill($data);
                $WorkerClientHours->save();
            }
        }

        return redirect('worker')->with('status', 'Часы работы были успешно сохранены.');

    }

    /**
     * Change Client’s Hours
     *
     */
    public function changeClientsHours(Request $request){
        $wc = WorkerClientHours::find($request->wc_id);
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

        $wc = new WorkerClientHours;
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
        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $lastUrlForReditect = $request->lastUrl;

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->salary = $request->salary;
        $user->role = 'worker';
        if($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users','public');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        if(!empty($request->client_worker_connect)){
            foreach($request->client_worker_connect as $client_worker_connect_id => $value){
                $cwc = new WorkerClient;
                $cwc->worker_id = $user->id;
                $cwc->client_id = $client_worker_connect_id;
                $cwc->save();
            }
        }

        return redirect($lastUrlForReditect)->with('status', 'Добавлен новый сотрудник: <b>'.$request->name.'</b>');

    }

    /**
     * Edit Worker From Client
     *
     */
    public function editWorkerFromClient(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $lastUrlForReditect = $request->lastUrl;

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->position = $request->position;
        $user->phone = $request->phone;
        $user->salary = $request->salary;

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

        WorkerClient::where('worker_id', $user->id)->delete();
        if(!empty($request->client_worker_connect)){
            foreach($request->client_worker_connect as $client_worker_connect_id => $value){
                $cwc = new WorkerClient;
                $cwc->worker_id = $user->id;
                $cwc->client_id = $client_worker_connect_id;
                $cwc->save();
            }
        }

        // delete user
        if(!empty($request->delete_user)){
            $user->active = 0;
            $user->save();
            return redirect($lastUrlForReditect)->with('status', 'Сотрудник <b>'.$user->name.'</b> были удален.');
        } else {
            return redirect($lastUrlForReditect)->with('status', 'Данные сотрудника <b>'.$request->name.'</b> были обновлены.');
        }

    }

}
