<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Presentation;
use App\Http\Resources\UserResource;
use App\Mail\Mailgun;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class VideosController extends Controller
{
    public function __construct () {
        $this->middleware('auth:api');
    }

    public function store (Request $request) {
        if (!$request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        $link = preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $request->url, $match);
        $video = $request->user()->videos()->create([
            'type' => $request->type,
            'url' => $match[1]
        ]);
        
        $users = request()->user()->followers->filter->hasNotificationsOn('notifyOnFavorites')->values();

        if (count($users)) {
            Presentation::dispatch($users, request()->user(), (new Mailgun(request()->user(), 'newVideo'))->render());
        }
        
        Cache::forget('athletes');
        $athletes = Cache::rememberForever('athletes', function () {
            return UserResource::collection(User::where('role', 'like', '%athlete%')->has('videos')->get());
        });

        return response()->json([
            'message' => 'New ' . $video->type . ' video added successfully!',
            'data' => new UserResource(request()->user()),
            'athletes' => [
                'data' => $athletes
            ]
        ], 201);
    }

    public function destroy (Request $request) {
        if (!$request->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        $video = Video::findOrFail($request->id);
        if ($request->user()->id != $video->user->id) {
            return response()->json([
                'message' => "Something went wrong!"
            ], 403);
        }

        $video->delete();
        
        Cache::forget('athletes');
        $athletes = Cache::rememberForever('athletes', function () {
            return UserResource::collection(User::where('role', 'like', '%athlete%')->has('videos')->get());
        });

        return response()->json([
            'message' => 'Video deleted successfully!',
            'data' => new UserResource(request()->user()),
            'athletes' => [
                'data' => $athletes
            ]
        ], 201);
    }
}
