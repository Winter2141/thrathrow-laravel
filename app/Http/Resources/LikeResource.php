<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Like */
class LikeResource extends JsonResource
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'comment_id' => $this->comment_id,

            'user' => new UserResource($this->whenLoaded('user')),
            'comment' => new CommentResource($this->whenLoaded('comment')),
        ];
    }
}
