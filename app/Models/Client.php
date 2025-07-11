<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'numero_telephone',
        'city_id',
        'filiere_id'
    ];

    public function ciity()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function publications()
    {
        return $this->hasMany(Publication::class)->orderBy('created_at', 'desc');
    }
}