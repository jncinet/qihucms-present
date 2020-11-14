<?php

namespace Qihucms\Present\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GivingOrderCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
