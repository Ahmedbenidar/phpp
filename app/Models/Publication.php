<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['contenu', 'image', 'professeur_id'];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}