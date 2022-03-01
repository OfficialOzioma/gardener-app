<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'location' => $this->location,
            'country' => $this->country,
            'Gardener' => GardenerResource::collection($this->whenLoaded('gardeners')),
            'Customers' => CustomerResource::collection($this->whenLoaded('customers')),
        ];
    }
}