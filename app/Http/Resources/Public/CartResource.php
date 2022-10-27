<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'product'=>new ProductResource($this->product),
            'size'=>new SizeResource($this->size),
            'quantity'=>$this->cart_quantity,
        ];
    }
}
