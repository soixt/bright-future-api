<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'type', 'url'
    ];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
