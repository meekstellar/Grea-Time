<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersSalary extends Model
{
    use HasFactory;

    protected $table = 'workers_salary';

    protected $guarded = [];

	public function user()
    {
        return $this->belongsTo('App\Models\User', worker_id);
    }

}
