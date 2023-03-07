<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recruiter extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'school_id', 'website', 'settings'
    ];

    protected $casts = [
        'settings'  => 'array'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function school () {
        return $this->belongsTo(School::class);
    }
}
