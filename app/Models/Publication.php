<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = ['contenu', 'professeur_id'];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
}
