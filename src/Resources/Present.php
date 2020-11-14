<?php

namespace Qihucms\Present\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Qihucms\Currency\Resources\Type\Type;

class Present extends JsonResource
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
            'name' => $this->name,
            'thumbnail' => empty($this->thumbnail) ? \Storage::url($this->thumbnail) : null,
            'image' => $this->thumbnail ? \Storage::url($this->image) : null,
            'animation' => $this->animation,
            'pay_currency_type' => new Type($this->pay_currency_type),
            'pay_amount' => $this->pay_amount,
            'unit' => $this->unit,
        ];
    }
}
