<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class ProducerResource extends JsonResource
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
            'about' => $this->about,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'youtube_url' => $this->youtube_url,
            'soundcloud_url' => $this->soundcloud_url,
            'instagram_url' => $this->instagram_url,
            'profile_image_url' => $this->profile_image_url,
            'beats_count' => $this->beats_count ?? 0,
        ];
    }
}
