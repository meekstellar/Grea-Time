<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsFees extends Model
{
    use HasFactory;

    protected $table = 'clients_fees';

    protected $guarded = [];

	public function user()
    {
        return $this->belongsTo('App\Models\User', user_id);
    }

}
