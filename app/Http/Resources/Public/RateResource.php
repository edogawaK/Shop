<?php

namespace App\Http\Resources\Public;

use App\Models\Rate;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->{Rate::COL_ID},
            'content' => $this->{Rate::COL_CONTENT},
            'point' => $this->{Rate::COL_POINT},
            'date' => $this->{Rate::COL_DATE},
            'orderId' => $this->{Rate::COL_ORDER},
            'productId' => $this->{Rate::COL_PRODUCT},
            'userId' => $this->{Rate::COL_USER},
        ];
    }
}
