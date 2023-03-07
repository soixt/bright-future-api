<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id', 'plan_id', 'promo_id', 'amount'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }

    public function plan () {
        return $this->belongsTo(Plan::class);
    }

    public function promo () {
        return $this->belongsTo(Promo::class);
    }
}
