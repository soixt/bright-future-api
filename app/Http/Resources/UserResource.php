<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->when(request()->user() && request()->user()->id == $this->id, $this->email),
            'extended' => [
                'bday' => $this->when($this->isRole == 'athlete' && !is_null($this->extended->bday), $this->extended->bday ? $this->extended->bday->format('d M Y') : $this->extended->bday),
                'about' => $this->when($this->isRole == 'athlete', $this->extended->about),
                'location' => $this->when($this->isRole == 'athlete', $this->extended->location),
                'presentations' => $this->when(request()->user() && request()->user()->id == $this->id && $this->isRole == 'athlete', $this->availablePresentations),
                'website' => $this->when(request()->user() && request()->user()->id == $this->id && $this->isRole == 'recruiter', $this->extended->website),
                'settings' => $this->when(request()->user() && request()->user()->id == $this->id && $this->isRole == 'recruiter', $this->extended->settings)
            ],
            'sports' => SportResource::collection($this->sports),
            'avatar' => $this->image,
            'role' => $this->when(request()->user() && request()->user()->id == $this->id, $this->isRole),
            'verified' => $this->when(request()->user() && request()->user()->id == $this->id, $this->hasVerifiedEmail()),
            'username' => $this->username,
            'videos' => $this->when($this->isRole == 'athlete', VideosResource::collection($this->videos->sortByDesc('created_at'))),
            'favorites' => $this->when(request()->user() && request()->user()->id == $this->id && $this->isRole == 'recruiter', $this->favorites->pluck('id'))
        ];
    }
}
