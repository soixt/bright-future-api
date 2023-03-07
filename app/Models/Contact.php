<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'school_id', 'sport_id', 'name', 'email', 'phone', 'position', 'off'
    ];

    public function school () {
        return $this->belongsTo(School::class);
    }

    public function sport () {
        return $this->belongsTo(Sport::class);
    }
}
