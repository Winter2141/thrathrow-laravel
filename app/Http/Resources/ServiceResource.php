<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Service */
class ServiceResource extends JsonResource
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
//            'old_id' => $this->old_id,
//            'created_at' => $this->created_at,
//            'updated_at' => $this->updated_at,
//            'users_count' => $this->users_count,

            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
