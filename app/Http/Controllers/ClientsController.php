<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use App\Services\ClientsService;

use App\Exports\xlsExport;
use App\Exports\pdfExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\WorkerClientHours;
use App\Models\ClientsFees;
use App\Models\User;
use App\Models\ClientsMarginality;

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
        $this->middleware('check.code');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, ClientsService $service)
    {

        if(auth()->user()->role != 'worker'){

            Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
                // Add some items to the menu...
                $event->menu->add([
                    'text' => 'Сотрудники',
                    'url' => 'workers',
                    'icon' => 'nav-icon fas fa-user-tie',
                    'classes' => 'top-nav-custom',
                ],
                [
                    'text' => 'Клиенты',
                    'url' => 'clients',
                    'icon' => 'nav-icon fas fa-user-secret',
                    'classes' => 'top-nav-custom',
                ]);

                if(auth()->user()->manager_important == 1){
                    $event->menu->add([
                        'text' => 'Администраторы',
                        'url' => 'managers',
                        'icon' => 'nav-icon fas fa-user-shield',
                        'classes' => 'top-nav-custom',
                    ]);
                }
            });

        }

        if(auth()->user()->role == 'worker'){
            return redirect()->route('worker');
        }


        if(!empty($request->export)){
            if($request->export == 'xls'){
                return Excel::download(new xlsExport($request->date_or_period, $request->w, $service), 'export_'.date('Y-m-d-H-i-s').'.xlsx');
            }
            if($request->export == 'pdf'){
                return Excel::download(new pdfExport($request->date_or_period, $request->w, $service), 'export_'.date('Y-m-d-H-i-s').'.pdf');
            }
        } else {
            return $service->WorkerClientHours($request->date_or_period, $request->w, 'clients');
        }

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

        if(empty($request->password)){
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

        # Встановлюємо маржинальність для цього місяця
        if(!empty($request->year) && !empty($request->month) && !empty($request->marginality)){
            $ClientsMarginality = ClientsMarginality::updateOrCreate(
                ['client_id' => $request->client_id, 'year' => $request->year, 'month' => $request->month],
                ['marginality' => $request->marginality]
            );
        }

        $user = User::where('id',$request->client_id)->first();
        return response()->json(['status' => true, 'messages' => 'Гонорар установлен для клиента '.$user->name.$ClientsFees->id.'']);
    }

    /**
     * show clients marginality
     *
     */
    public function show_clients_marginality(Request $request){
        if(auth()->user()->role == 'manager'){
            $ClientsMarginality = User::find($request->client_id)
                ->get_marginality()
                ->toJson();
            return $ClientsMarginality;
        } else {
            return response()->json(['status' => false, 'messages' => 'У вас немає доступа'] , 403);
        }
    }

    /**
     * get Clients
     *
     */
    public function getClients(Request $request)
    {
        $clientIds = $request->input('client_ids'); // Отримуємо IDs з запиту

        // Перевірка, чи є IDs, і пошук клієнтів
        if (is_array($clientIds)) {
            $clients = User::whereIn('id', $clientIds)
                ->where('role', 'client')
                ->select('id','name')
                ->orderBy('name', 'asc')
                ->get();
            return response()->json(['success' => true, 'clients' => $clients]);
        } else {
            $clients = User::where('role', 'client')
                ->select('id','name')
                ->orderBy('name', 'asc')
                ->get();
            return response()->json(['success' => true, 'clients' => $clients]);
        }

    }

}
