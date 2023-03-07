<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Athlete extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'location', 'gender', 'bday', 'about', 'additional', 'settings'
    ];

    protected $casts = [
        'bday'  => 'datetime:d-m-Y',
        'additional' => 'array',
        'settings' => 'array'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
}