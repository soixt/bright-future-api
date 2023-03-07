<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Mail\Mailgun;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use App\Notifications\WelcomeNotification;
use App\Models\Presentation;
use App\Models\Contact;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    public function __construct () {
        $this->middleware('auth:api')->only(['user', 'logout']);
    }

    public function signupathlete() {
        request()->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'location' => 'required',
            'bday' => 'required',
            'gender' => 'required|in:male,female',
            'sports' => 'required'
        ]);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'role' => User::setRole('athlete'),
            'username' => User::generateUsername(request()->name)
        ]);

        if (is_array(request()->sports) && !isset(request()->sports['id'])) {
            foreach (request()->sports as $sport) {
                $user->sports()->attach($sport['id']);
            }
        } else {
            $user->sports()->attach(request()->sports['id']);
        }

        $user->extended()->create([
            'location' => request()->location,
            'bday' => Carbon::parse(request()->bday),
            'gender' => request()->gender
        ]);

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $user->getKey(), 'hash' => sha1($user->email)]);
        
        $user->notify(new WelcomeNotification($user->name, 'Set up your profile quickly and present yourself to hundreds of recruiters that can choose to offer YOU some scholarships!', [
            'text' => 'Activate & Start',
            'url' => config('app.api_url') . '/app/verification/' . explode('auth/email/verify/', $url)[1] 
        ]));

        $users = User::where('role', 'like', '%recruiter%')->whereHas('sports', function ($query) use ($user) {
            $query->where('sports.id', '=', $user->sports->first()->id);
        })->get()->filter->hasNotificationsOn()->values();

        if (count($users)) {
            Presentation::dispatch($users, $user, (new Mailgun($user, 'newAthlete'))->render());
        }
        
        return response()->json([
            'message' => 'You have signed up succesfully and we have sent you account activation link to your email! We are signing you in!'
        ], 201);
    }

    public function signuprecruiter() {
        request()->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'website' => 'required',
            'sports' => 'required'
        ]);

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'password' => bcrypt(request()->password),
            'role' => User::setRole('recruiter'),
            'username' => User::generateUsername(request()->name)
        ]);

        foreach (request()->sports as $sport) {
            $user->sports()->attach($sport['id']);
        }

        $user->extended()->create([
            'website' => request()->website,
            "settings" => [
                'notifyOnNew' => false,
                'notifyOnFavorites' => true,
                'instantSportFilter' => true
            ]
        ]);

        if ($contact = Contact::where('email','=',$user->email)->first()) {
            $user->extended->website = $contact->school->website;
            $user->extended->school_id = $contact->school->id;
            $user->extended->save();
        }

        $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), ['id' => $user->id, 'hash' => sha1($user->email)]);
        
        $user->notify(new WelcomeNotification($user->name, 'We are happy to see new recruiters every day and we hope that you can find your future stars here!', [
            'text' => 'Activate & Start',
            'url' => config('app.api_url') . '/app/verification/' . explode('auth/email/verify/', $url)[1]
        ]));
        
        return response()->json([
            'message' => 'You have signed up succesfully and we have sent you account activation link to your email! We are signing you in!'
        ], 201);
    }

    public function login() {
        request()->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);

        if(!Auth::attempt(request(['email', 'password']), true)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $tokenResult = request()->user()->createToken('Personal Access Token');

        $token = $tokenResult->token;

        $token->expires_at = Carbon::now()->addYear();

        $token->save();

        return response()->json([
            'message' => 'Logged In Successfully!',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    
    public function logout () {
        request()->user()->token()->revoke();
        
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
    
    public function user () {
        return response()->json(new UserResource(request()->user()));
    }
    
    public function forgot () {
        $credentials = request()->validate(['email' => 'required|email']);
        Password::sendResetLink($credentials);
        return response()->json([
            'message' => "Password reset link has been sent to " . request()->email . ". If you don't see email, please check your spam or promotions folders."
        ]);
    }

    public function reset () {
        $credentials = request()->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|confirmed'
        ]);

        $reset_password_status = Password::reset($credentials, function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(["message" => "Invalid token provided"], 400);
        }

        return response()->json(["message" => "Your password has been reset, you can log in now."]);
    }
}
