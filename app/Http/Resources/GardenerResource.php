<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GardenerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $numberOfCustomers = $this->whenLoaded('numberOfCustomers');
        return  [

            'fullname' => $this->fullname,
            'email' => $this->email,
            'Location' => new LocationResource($this->whenLoaded('location')),
            'Customer' => CustomerResource::collection($this->whenLoaded('customers')),
            'number of customers' => $this->numberOfCustomers(),
            // 'number of customers' => new CustomerResource($numberOfCustomers),
        ];
    }
}