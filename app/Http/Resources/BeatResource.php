<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Beat */
class BeatResource extends JsonResource
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
            'price' => $this->price,
            'description' => $this->description,
            'artwork_url' => $this->artwork_url,
            'play_url' => $this->play_url,
            'bpm' => $this->bpm,
//            'download_url' => $this->download_url,
//            'weight' => $this->weight,
//            'duration' => $this->duration,
            'is_free' => $this->is_free,
            'is_exclusive' => $this->is_exclusive,
            'download_enabled' => $this->download_enabled,
            'purchase_enabled' => $this->purchase_enabled,
            'status' => $this->status,
            'created_at' => $this->created_at,
//            'purchases' => $this->purchases,
            'uploader' => new ProducerResource($this->whenLoaded('uploader')),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
        ];
    }
}
