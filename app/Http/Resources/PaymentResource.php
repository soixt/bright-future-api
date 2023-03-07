<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'plan' => [
                'name' => $this->plan->name,
                'price' => $this->plan->price,
                'presentations' => $this->plan->presentations
            ],
            'promo' => $this->promo,
            'paid' => $this->amount,
            'date' => $this->created_at->isoFormat("MMMM Do YYYY")
        ];
    }
}
