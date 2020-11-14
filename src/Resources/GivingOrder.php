<?php

namespace Qihucms\Present\Resources;

use App\Http\Resources\User\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class GivingOrder extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'present' => new Present($this->present),
            'to_user' => new User($this->to_user),
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => Carbon::parse($this->created_at)->diffForHumans(),
            'updated_at' => Carbon::parse($this->updated_at)->diffForHumans(),
        ];
    }
}
