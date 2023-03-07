<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use App\Models\Contact;
use App\Notifications\NewMessage;

class MessageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }

    public function send (User $user) {
        if (!request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'To do this, you need too verify your account.',
                'code' => 'activate'
            ], 403);
        }
        $message = Message::create([
            'from_id' => request()->user()->id,
            'to_id' => $user->id,
            'body' => request()->body
        ]);
        
        $note = "Note: This recruiter is not connected to any schools we are presenting you to, so anything he offers is not verified!";

        if (Contact::where('email','=',request()->user()->email)->first()) {
            $note = "";
        }

        $user->notify(new NewMessage($user, request()->user(), $note, $message));

        return response()->json([
            'message' => 'Email Has Been Sent Sucessfully To ' . $user->name . '!'
        ], 201);
    }
}
