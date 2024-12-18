<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\SendingReminder;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

class SendReminderController extends Controller
{
    /**
     * get Clients
     *
     */
    public function sendReminder(Request $request)
    {
        if(!empty($request->worker_id)){

            $user = User::find($request->worker_id);

            if(!empty($user->name)){
                $data = [
                    'username' => $user->name,
                    'day' => $request->day,
                ];

                Mail::to($user->email)
                    ->cc(auth()->user()->email)
                    ->send(new SendMail($data));

                $SendingReminder = new SendingReminder;
                $SendingReminder->worker_id = $request->worker_id;
                $SendingReminder->day = new Carbon($request->day);
                $SendingReminder->save();

                return response()->json(['status' => true, 'message' => 'sended']);
            } else {
                return response()->json(['status' => false, 'message' => 'Error EGD']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Error DTG']);
        }
    }
}
