<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Fee
     *
     * @var array<int>
     */
	public function fee($year, $month)
    {
        return $this->hasOne('App\Models\ClientsFees', 'client_id')
            ->where('year', $year)
            ->where('month', $month)
            ->first();
    }

    /**
     * Fee
     *
     * @var array<int>
     */
	public function sent_mail_in_this_day($day)
    {

        $parsedDate = Carbon::createFromFormat('d-m-Y', $day)->startOfDay();
        $sr = $this->hasOne('App\Models\SendingReminder', 'worker_id')
            ->where('day', $parsedDate)
            ->first();
        if(!empty($sr)){
            return 1;
        } else {
            return 0;
        }
    }

	public function get_connect_clients_id()
    {
        return 'App\Models\WorkerClient'::where('worker_id', $this->id)->get()->pluck('client_id')->toArray();
    }

	public function get_marginality()
    {
        return 'App\Models\ClientsMarginality'::where('client_id', $this->id)
            ->orderBy('year', 'DESC')
            ->orderBy('month', 'DESC')
            ->get();
    }

	public function get_current_salary($year = 0, $month = 0)
    {
        if(empty($year)){
            $year = date("Y",time());
        }
        if(empty($month)){
            $month = date("n",time());
        }
        $WorkersSalary = 'App\Models\WorkersSalary'::where('worker_id',$this->id)
            ->where('year',$year)
            ->where('month',$month)
            ->first();

        return (!empty($WorkersSalary) && !empty($WorkersSalary->salary) ? $WorkersSalary->salary : 0);
    }

	public function get_pay_per_one_hour($year = 0, $month = 0)
    {
        if(empty($year)){
            $year = date("Y",time());
        }
        if(empty($month)){
            $month = date("n",time());
        }
        $WorkersSalary = 'App\Models\WorkersSalary'::where('worker_id',$this->id)
            ->where('year',$year)
            ->where('month',$month)
            ->first();

        $pay_per_one_hour = (!empty($WorkersSalary) && !empty($WorkersSalary->salary) ? $WorkersSalary->salary : 0) / 160;
        return round($pay_per_one_hour,2);
    }

}
