<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

use App\Models\User;

use Carbon\Carbon;

class ManagersController extends Controller
{
    //
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
    public function index(Request $request)
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

        if(auth()->user()->role == 'worker' || auth()->user()->manager_important != 1){
            return redirect()->route('workers');
        }

        // List users
        $managers = User::where('role', 'manager')->
            where('manager_important', '0')->
            where('active', '1')->
            orderBy('name', 'asc')->
            get();

        return view('managers')->with([
			'managers'=>$managers,
		]);
    }

    /**
     * Add New Manager
     *
     */
    public function addNewManager(Request $request){

        if(auth()->user()->manager_important != 1){
            return redirect()->route('workers');
        }

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $lastUrlForReditect = $request->lastUrl;

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->access_to_salary = (!empty($request->access_to_salary) ? $request->access_to_salary : 0);
        $user->active = 1;
        $user->manager_important = 0;
        $user->phone = $request->phone;
        $user->role = 'manager';
        if($request->hasFile('image')) {
            $user->image = $request->file('image')->store('users','public');
        }

        if(empty($request->password)){
            $request->password = 'password';
        }
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect($lastUrlForReditect)->with('status', 'Добавлен новый администратор: <b>'.$request->name.'</b>');

    }

    /**
     * Remove Manager
     *
     */
    public function removeManager(Request $request){

        if(auth()->user()->manager_important != 1){
            return redirect()->route('workers');
        }

        $user = User::find($request->id);
        $user_name = $user->name;
        $user->delete();
        return redirect()->back()->with('status', 'Удален администратор:
        <b>'.$user_name.'</b>');
    }

    /**
     * Edit Manager
     *
     */
    public function editManager(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        $lastUrlForReditect = $request->lastUrl;

        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->access_to_salary = (!empty($request->access_to_salary) ? $request->access_to_salary : 0);

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
            return redirect($lastUrlForReditect)->with('status', 'Администратор <b>'.$user->name.'</b> были удален.');
        } else {
            return redirect($lastUrlForReditect)->with('status', 'Данные администратора <b>'.$request->name.'</b> были обновлены.');
        }

    }

}
