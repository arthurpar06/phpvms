<?php

namespace App\Http\Resources;

use App\Contracts\Resource;

/**
 * @mixin BidResource
 */
class UserBidResource extends Resource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'flight_id'  => $this->flight_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'flight'     => new FlightResource($this->whenLoaded('flight')),
        ];
    }
}
