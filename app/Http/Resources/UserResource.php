<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\User */
class UserResource extends JsonResource
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
            'email_verified_at' => $this->email_verified_at,
            'about' => $this->about,
            'facebook_url' => $this->facebook_url,
            'twitter_url' => $this->twitter_url,
            'youtube_url' => $this->youtube_url,
            'soundcloud_url' => $this->soundcloud_url,
            'instagram_url' => $this->instagram_url,
            'profile_image_url' => $this->profile_image_url,
            'beats_count' => $this->beats_count,
//            'genres_count' => $this->genres_count,
//            'notifications' => $this->notifications,
//            'notifications_count' => $this->notifications_count,
//            'purchases' => $this->purchases,
//            'purchases_count' => $this->purchases_count,
            'account_number' => $this->accounts()->count(),
            'needs_onboarding' => $this->when($this->beats_count > 0, $this->accounts->count() === 0),
//            'needs_onboarding' => $this->accounts->count() === 0,

            'beats' => BeatResource::collection($this->whenLoaded('beats')),
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'services' => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
