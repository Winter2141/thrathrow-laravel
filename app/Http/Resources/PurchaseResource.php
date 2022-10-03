<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Purchase */
class PurchaseResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'price' => $this->price,
            'user_id' => $this->user_id,
            'confirmed_at' => $this->confirmed_at,
            'old_id' => $this->old_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
//            'beats' => $this->beats,
            'beats_count' => $this->beats_count,
//            'buyer' => $this->buyer,

            'beats' => BeatResource::collection($this->whenLoaded('beats')),
            'buyer' => new UserResource($this->whenLoaded('buyer')),
        ];
    }
}
