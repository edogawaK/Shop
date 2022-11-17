<?php

namespace App\Http\Resources\Public;

use App\Models\Sale;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
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
            'id' => $this->{Sale::COL_ID},
            'name' => $this->{Sale::COL_NAME},
            'discount' => $this->{Sale::COL_DISCOUNT},
            'unit' => $this->{Sale::COL_UNIT},
            'startDate' => $this->{Sale::COL_DATE},
            'endDate' => $this->{Sale::COL_END},
            'adminId' => $this->{Sale::COL_ADMIN},
            'total' => $this->total,

            'poducts' => $this->whenLoaded($this->products, function () {
                return ProductResource::collection($this->products);
            }),
        ];
    }
}
