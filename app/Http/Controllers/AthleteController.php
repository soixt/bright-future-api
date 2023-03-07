<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;

class AthleteController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api')->only(['favorite', 'unfavorite']);
    }

    public function index () {
        return Cache::rememberForever('athletes', function () {
            return UserResource::collection(User::where('role', 'like', '%athlete%')->has('videos')->get());
        });
    }

    public function show ($username) {
        return new UserResource(User::where([['username','=', $username], ['role','like','%athlete%']])->firstOrFail());
    }

    public function favorite (User $user) {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        request()->user()->favorites()->detach($user);
        request()->user()->favorites()->attach($user);
        return response()->json([
            'message' => $user->name . ' Added To Favorites Successfully!',
            'user_id' => $user->id
        ], 201);
    }

    public function unfavorite (User $user) {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        request()->user()->favorites()->detach($user);
        return response()->json([
            'message' => $user->name . ' Removed From Favorites Successfully!',
            'user_id' => $user->id
        ], 201);
    }
}
