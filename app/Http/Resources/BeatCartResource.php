<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Beat */
class BeatCartResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'artwork_url' => $this->artwork_url,
            'is_exclusive' => $this->is_exclusive,
            'status' => $this->status,
            'price' => $this->whenPivotLoaded('beat_cart', function () {
                return $this->pivot->price;
            }),
        ];
    }
}
