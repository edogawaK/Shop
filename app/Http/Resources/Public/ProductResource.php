<?php

namespace App\Http\Resources\Public;

use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request, ...$mode)
    {
        return [
            //basic
            'id' => $this->{Product::COL_ID},
            'name' => $this->{Product::COL_NAME},
            'price' => $this->{Product::COL_PRICE},
            'salePrice'=>$this->when($this->{Product::COL_SALE}, function(){
                return $this->{Product::COL_PRICE}
            }),
            'avt' => $this->{Product::COL_AVT},
            'status' => $this->{Product::COL_STATUS},

            //detail
            $this->mergeWhen($this->detail, [
                'desc' => $this->{Product::COL_DESC},
                'images' => ImageResource::collection($this->images),
                'sizes' => $this->getProductAmount($this->sizes),
            ]),
        ];
    }

    private function shouldDetail($request)
    {
        // return $request->route()->getName() === 'products.show'||$request->user()->;
    }

    private function getProductAmount($data)
    {
        $response = [];
        if (is_countable($data)) {
            foreach ($data as $item) {
                $response[] = [
                    'id' => $item->{Size::COL_ID},
                    'name' => $item->{Size::COL_NAME},
                    'quantity' => $item->pivot->quantity,
                ];
            }
        } else {
            $response[] = [
                'id' => $data->{Size::COL_ID},
                'name' => $data->{Size::COL_NAME},
                'quantity' => $data->pivot->quantity,
            ];
        }
        return $response;
    }
}
