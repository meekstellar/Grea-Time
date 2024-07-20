<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\WorkerClient;

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
    public function index()
    {
        WorkerClient::where('hours',0)->delete();

        return view('clients');
    }
}
