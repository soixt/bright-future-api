<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConfigurationResource;
use App\Http\Resources\SchoolsResource;
use App\Http\Resources\SportResource;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\Sport;
use Illuminate\Support\Facades\Cache;
use App\Models\School;
use App\Models\Communication;
use App\Models\Configuration;

class WebsiteController extends Controller
{
    public function sports () {
        return Cache::rememberForever('sports', function () {
            return SportResource::collection(Sport::all());
        });
    }

    public function schools () {
        return Cache::rememberForever('schools', function () {
            return SchoolsResource::collection(School::has('contacts')->get());
        });
    }

    public function configurations () {
        return Cache::rememberForever('configurations', function () {
            return new ConfigurationResource(Configuration::first());
        });
    }

    public function stop () {
        $contact = Contact::where('stop','=',request()->hash)->first();

        if (is_null($contact)) {
            return response()->json([
                'message' => 'This action cannot be done because this link is invalid!'
            ], 401);
        }

        $contact->off = true;
        $contact->save();

        return response()->json([
            'message' => 'Emails turned off successfully!'
        ]);
    }

    public function cominucation () {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email',
            'reason' => 'required',
            'message' => 'required'
        ]);

        $communication = Communication::create(request()->all());

        return response()->json([
            'message' => 'Message has been sent!'
        ]);
    }
}
