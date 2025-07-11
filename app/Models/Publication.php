<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['contenu', 'client_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

   
}