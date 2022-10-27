<?php

namespace App\Http\Resources\Public;

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
            'id' => $this->product_id,
            'name' => $this->product_name,
            'price' => $this->product_price,
            'avt' => $this->product_avt,
            'status' => $this->product_status,

            //detail
            $this->mergeWhen($this->isDetailRequest($request), [
                'desc' => $this->product_desc,
                'images' => ImageResource::collection($this->images),
                'sizes' => $this->getProductAmount($this->sizes),
            ]),
        ];
    }

    private function isDetailRequest($request)
    {
        return $request->route()->getName() === 'products.show';
    }

    private function getProductAmount($data)
    {
        $response = [];
        if (is_countable($data)) {
            foreach ($data as $item) {
                $response[] = [
                    'id' => $item->size_id,
                    'name' => $item->size_name,
                    'quantity' => $item->pivot->quantity,
                ];
            }
        } else {
            $response[] = [
                'id' => $data->size_id,
                'name' => $data->size_name,
                'quantity' => $data->pivot->quantity,
            ];
        }
        return $response;
    }
}
