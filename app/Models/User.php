<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;
use Carbon\Carbon;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'role', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $roles = [
        'athlete' => 'App\Models\Athlete',
        'recruiter' => 'App\Models\Recruiter',
        'admin' => 'App\Models\Admin',
        'moderator' => 'App\Models\Moderator'
    ];

    public static function setRole ($role) {
        return self::$roles[$role];
    }

    public function extended () {
        return $this->hasOne($this->role);
    }

    public function athlete () {
        return $this->hasOne(Athlete::class);
    }

    public function videos () {
        return $this->hasMany(Video::class);
    }

    public static function generateUsername ($username) {        
        return self::newUsername((string) Str::of($username)->slug('.'));
    }
    
    public static function newUsername ($username, $num = 0) {
        if ($num == 0) {
            $newUsername = $username;
        } else {
            $newUsername = $username . '.' . $num;
        }
        if (self::where('username', '=', $newUsername)->count() > 0) {
            return self::newUsername($username, $num + 1);
        } else {
            return $newUsername;
        }
    }

    public function getImageAttribute () {
        return $this->avatar ? config('app.url') . 'storage/' . $this->avatar : config('app.api_url') . '/user.png';
    }

    public function getIsRoleAttribute () {
        return array_search($this->role, self::$roles);
    }

    public function getAvailablePresentationsAttribute () {
        $p = 0;

        foreach ($this->payments as $payment) {
            $p = $p + $payment->plan->presentations;
        }

        return $p - count($this->presentations);
    }

    public function getAgeAttribute() {
        return Carbon::parse($this->bday)->age;
    }

    public function presentations () {
        return $this->hasMany(Presentation::class);
    }

    public function payments () {
        return $this->hasMany(Payment::class);
    }

    public function favorites () {
        return $this->belongsToMany(User::class, 'favorites', 'user_id', 'athlete_id');
    }

    public function followers () {
        return $this->belongsToMany(User::class, 'favorites', 'athlete_id', 'user_id');
    }

    public function sports () {
        return $this->belongsToMany(Sport::class, 'sport_user', 'user_id', 'sport_id');
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function hasNotificationsOn ($set = 'notifyOnNew') {
        return (bool) $this->extended->settings[$set];
    }

    public function sendEmailVerificationNotification() {
        $this->notify(new VerifyEmailNotification($this->name));
        

        return response()->json([
            'message' => 'Activation link has been sent to you email.'
        ], 204);
    }
}
