<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $fillable = ['name'];

    public function recruiters () {
        return $this->belongsToMany(User::class, 'sport_user', 'sport_id', 'user_id')->where('role','like','%recruiter%');
    }

    public function contacts () {
        return $this->hasMany(Contact::class)->where('off', '=', 0);
    }
}
