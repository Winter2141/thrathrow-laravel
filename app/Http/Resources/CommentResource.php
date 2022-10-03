<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Comment */
class CommentResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $user = \Auth::user();

        return [
            'id' => $this->id,
            'content' => $this->content,
            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
            'likes_count' => $this->likes_count,

//            'user_id' => $this->user_id,
//            'beat_id' => $this->beat_id,

//            'beat' => new BeatResource($this->whenLoaded('beat')),
//            'likes' => LikeResource::collection($this->whenLoaded('likes')),
            'has_liked' => $this->when($user !== null, function () use ($user) {
                return $this->likers()->where('user_id', $user->id)->count() > 0;
            }),
            'user' => new UserResource($this->whenLoaded('user', function () {
                return $this->user->makeHidden([
                    'email_verified_at',
                    'about',
                    'facebook_url',
                    'twitter_url',
                    'youtube_url',
                    'soundcloud_url',
                    'instagram_url',
                    'beats_count',
                    'account_number',
                    'needs_onboarding',
                    'beats',
                    'genres',
                    'services',
                ]);
            })),
        ];
    }
}
