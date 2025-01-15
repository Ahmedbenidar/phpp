<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['contenu', 'professeur_id'];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedByUser($userId)
    {
        return $this->likes()->where('professeur_id', $userId)->exists();
    }
}