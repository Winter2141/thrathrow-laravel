<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Cart */
class CartResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
//            'user_id' => $this->user_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'beats' => $this->beats,
//            'beats_count' => $this->beats_count,

            'beats' => BeatCartResource::collection($this->whenLoaded('beats')),
        ];
    }
}
