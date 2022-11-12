<?php

namespace App\Http\Resources\Public;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->{Order::COL_ID},
            'date' => $this->{Order::COL_DATE},
            'receive' => $this->{Order::COL_RECEIVE},
            'total' => $this->{Order::COL_TOTAL},
            'status' => $this->{Order::COL_STATUS},
            'locateId' => $this->{Order::COL_LOCATE},
            'detail'=>$this->getOrderProducts(),
        ];
    }

    private function getOrderProducts(){
        return OrderDetailResource::collection($this->detail);
    }
}
