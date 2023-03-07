<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sport;

class School extends Model
{
    protected $fillable = [
        'division', 'league', 'state', 'name', 'website'
    ];

    protected $appends = ['sports'];

    public function contacts () {
        return $this->hasMany(Contact::class);
    }

    public function getSportsAttribute () {
        return Sport::whereIn('id', $this->contacts->unique('sport_id')->pluck('sport_id'))->get();
    }
}
