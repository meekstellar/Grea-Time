<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientsMarginality extends Model
{
    use HasFactory;

    protected $table = 'clients_marginality';

    protected $guarded = [];

	public function user()
    {
        return $this->belongsTo('App\Models\User', client_id);
    }

}
