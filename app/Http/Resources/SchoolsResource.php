<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SchoolsResource extends JsonResource
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
            'league' => $this->league,
            'division' => $this->division,
            'state' => $this->state,
            'name' => $this->name,
            'website' => $this->website,
            'sports' => SportResource::collection($this->sports)
        ];
    }
}
