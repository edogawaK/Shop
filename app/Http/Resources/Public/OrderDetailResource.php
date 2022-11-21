<?php

namespace App\Http\Resources\Public;

use App\Models\Image;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderDetailResource extends JsonResource
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
            'product' => [
                'id' => $this->product->{Product::COL_ID},
                'name' => $this->product->{Product::COL_NAME},
                'image' => $this->product->avatar->{Image::COL_LINK},
                'price' => $this->product->{Product::COL_PRICE},
            ],
            'size' => [
                'id' => $this->size->{Size::COL_ID},
                'name' => $this->size->{Size::COL_NAME},
                'quantity' => $this->{OrderDetail::COL_QUANTITY},
            ],
        ];
    }
}
