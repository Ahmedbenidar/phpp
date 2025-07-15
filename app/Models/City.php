<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['cityName'];

    public function clients()
    {
        return $this->hasMany(Client::class,'city_id');
    }
}