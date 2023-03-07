<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Promo;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Presentation;
use App\Mail\Mailgun;

class SettingsController extends Controller
{
    public function __construct () {
        $this->middleware('auth:api');
    }

    public function avatar () {  
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        Storage::disk('public')->delete(request()->user()->avatar);
        $path = request()->user()->id . '/' . time() . '.png';
        Storage::put('public/' . $path, file_get_contents(request()->file));
        request()->user()->avatar = $path;
        request()->user()->save();

        return response()->json([
            'message' => 'Image Changed Successfully!',
            'data' => new UserResource(User::find(request()->user()->id))
        ], 201);
    }

    public function general () {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        if (!Hash::check(request()->currentPassword, request()->user()->password)) {
            return response()->json([
                'message' => "Your password is incorrect!"
            ], 403);
        }

        request()->validate([
            'name' => 'sometimes|nullable|min:2',
            'password' => 'sometimes|nullable|min:8',
            'email' => 'required|email'
        ]);

        if (User::where([['email', '=', request()->email], ['id', '!=', request()->user()->id]])->get()->count() > 0) {
            return response()->json([
                'message' => "Email is already in use, try another!"
            ], 401);
        }
        
        if (request()->user()->name != request()->name) {
            request()->user()->name = request()->name;
        }

        if (request()->user()->email != request()->email) {
            request()->user()->email = request()->email;
        
            // Send confirmation email to new email address
        }

        if (request()->password != '' && request()->password != null) {
            request()->user()->password = bcrypt(request()->password);

            // Uncomment if want to remove tokens and create new token
            // $tokenResult = request()->user()->createToken('Personal Access Token');
            // $token = $tokenResult->token;
            // $token->expires_at = Carbon::now()->addYear();
            // $token->save();

            // return response()->json([
            //     'token' => 'Bearer ' . $tokenResult->accessToken,
            // ], 201);
        }

        request()->user()->save();

        return response()->json([
            'message' => 'General Settings Were Successfully Updated!',
            'data' => new UserResource(User::find(request()->user()->id))
        ], 201);
    }

    public function account () {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        if (!Hash::check(request()->currentPassword, request()->user()->password)) {
            return response()->json([
                'message' => "Your password is incorrect!"
            ], 403);
        }

        if (request()->user()->isRole == 'athlete') {
            request()->validate([
                'location' => 'required',
                'birthday' => 'required'
            ]);

            if (request()->user()->extended->location != request()->location) {
                request()->user()->extended->location = request()->location;
            }

            if (request()->user()->extended->about != request()->about) {
                request()->user()->extended->about = request()->about;
            }

            if (request()->user()->extended->bday != request()->bday) {
                request()->user()->extended->bday = Carbon::parse(request()->bday);
            }

        } else if (request()->user()->isRole == 'recruiter') {
            request()->validate([
                'website' => 'required',
                'notifyOnFavorites' => 'required',
                'notifyOnNew' => 'required',
                'sports' => 'required'
            ]);

            foreach (request()->user()->sports as $sport) {
                request()->user()->sports()->detach($sport);
            }
    
            foreach (request()->sports as $sport) {
                request()->user()->sports()->attach($sport['id']);
            }

            if (request()->user()->extended->website != request()->website) {
                request()->user()->extended->website = request()->website;

                // Check if want, is website similar in schools and if is connect to it
            }

            request()->user()->extended->settings = [
                'notifyOnNew' => request()->notifyOnNew,
                'notifyOnFavorites' => request()->notifyOnFavorites,
                'instantSportFilter' => request()->instantSportFilter
            ];

        } else { }

        request()->user()->extended->save();

        return response()->json([
            'message' => 'Account Settings Were Successfully Updated!',
            'data' => new UserResource(User::find(request()->user()->id))
        ], 201);
    }

    public function secretcode () {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        if (!Hash::check(request()->currentPassword, request()->user()->password)) {
            return response()->json([
                'message' => "Your password is incorrect!"
            ], 403);
        }

        request()->validate([
            'secret' => 'required|exists:promos,code'
        ]);

        $promo = Promo::where('code', '=', request()->secret)->first();

        if (Payment::where('promo_id', '=', $promo->id)->count() == 0 || ($promo->multiple && request()->user()->payments->where('promo_id', '=', $promo->id)->count() == 0)) {
            request()->user()->payments()->create([
                'plan_id' => $promo->plan->id,
                'promo_id' => $promo->id,
                'amount' => 0
            ]);

            return response()->json([
                'message' => 'Presentation Was Successfully Added!',
                'data' => new UserResource(User::find(request()->user()->id))
            ], 201);
        }
        
        return response()->json([
            'message' => "You can not use same code more than once!"
        ], 401);
    }

    public function present () {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        if (!Hash::check(request()->currentPassword, request()->user()->password)) {
            return response()->json([
                'message' => "Your password is incorrect!"
            ], 403);
        }

        if (request()->user()->availablePresentations > 0) {

            if (request()->user()->presentations->count() == 0 || request()->user()->presentations->last()->created_at < now()->subDays(5)) {

                Presentation::dispatch(request()->user()->sports->first()->contacts, request()->user(), (new Mailgun(request()->user(), 'present'))->render());

                request()->user()->presentations()->create();

                return response()->json([
                    'message' => 'Presentation Was Successfully Sent!',
                    'data' => new UserResource(User::find(request()->user()->id))
                ], 201);
            }

            $date = Carbon::parse(request()->user()->presentations->last()->created_at);

            $diff = $date->diffInDays(now()->subDays(5));
            
            return response()->json([
                'message' => "Five days must pass in between presentations! Your next presentation will be available in " . $diff . " days."
            ], 401);
        }

        return response()->json([
            'message' => "You don't have any available presentations left!"
        ], 401);
    }
}
