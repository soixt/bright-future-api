<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'plan_id', 'code', 'multiple'
    ];

    public $timestamps = false;

    public function plan () {
        return $this->belongsTo(Plan::class);
    }
}
