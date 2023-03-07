<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller {
    use VerifiesEmails;

    public function __construct() {
        $this->middleware('auth:api');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function resend () {
        if (request()->user()->hasVerifiedEmail()) {
            return response()->json([
                'message' => 'Your account is already activated!'
            ], 200);
        }

        request()->user()->sendEmailVerificationNotification();

        return response()->json([
            'message' => 'Activation link has been sent to your email.'
        ], 200);
    }
}
