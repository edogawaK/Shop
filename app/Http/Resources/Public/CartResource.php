<?php

namespace App\Http\Resources\Public;

use App\Models\Cart;
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
            'cartId' => $this->{Cart::COL_ID},
            'product' => new ProductResource($this->product),
            'size' => new SizeResource($this->size),
            'quantity' => $this->{Cart::COL_QUANTITY},
        ];
    }
}
