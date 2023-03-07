<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'athlete_id'];

    public function recruiters () {
        return $this->belongsToMany(User::class);
    }
}
