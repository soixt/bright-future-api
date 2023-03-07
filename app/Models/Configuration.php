<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = ['schoolsInfo', 'sportsScholarshipsMoreInfo', 'legalInfo', 'creatorStory'];

    protected $casts = [
        'schoolsInfo'  => 'array'
    ];
}
