<?php

namespace Qihucms\Present\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
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
            'thumbnail' => !empty($this->thumbnail) ? Storage::url($this->thumbnail) : null,
            'image' => !empty($this->image) ? Storage::url($this->image) : null,
            'animation' => !empty($this->animation) ? Storage::url($this->animation) : null,
            'pay_currency_type' => new Type($this->pay_currency_type),
            'pay_amount' => $this->pay_amount,
            'unit' => $this->unit,
        ];
    }
}
