<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = ['cityName'];

    public function professeurs()
    {
        return $this->hasMany(Professeur::class,'city_id');
    }
}
