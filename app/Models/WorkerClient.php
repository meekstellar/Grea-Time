<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerClient extends Model
{
    use HasFactory;

    protected $table = 'workers_clients';

    protected $guarded = [];

    public $timestamps = false;

	public function worker()
    {
        return 'App\Models\User'::where('id', $this->worker_id)->first();
    }

	public function client()
    {
        return 'App\Models\User'::where('id', $this->client_id)->first();
    }

	public function get_workers()
    {
        return 'App\Models\User'::where('id', $this->worker_id)->get();
    }

	public function get_clients()
    {
        return 'App\Models\User'::where('id', $this->client_id)->get();
    }

}
