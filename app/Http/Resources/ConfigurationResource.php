<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConfigurationResource extends JsonResource
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
            'schoolsInfo' => $this->schoolsInfo,
            'sportsScholarshipsMoreInfo' => $this->sportsScholarshipsMoreInfo,
            'legalInfo' => $this->legalInfo,
            'creatorStory' => $this->creatorStory
        ];
    }
}
