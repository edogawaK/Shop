<?php

namespace App\Http\Resources\Public;

use App\Models\Locate;
use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Locale;

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
            'user' => new UserResource($this->user),
            'date' => $this->{Order::COL_DATE},
            'receive' => $this->{Order::COL_RECEIVE},
            'total' => $this->{Order::COL_TOTAL},
            'status' => $this->getOrderStatus(),
            'statusId' => $this->{Order::COL_STATUS},
            'address' => $this->locate->{Locate::COL_STREET},
            'detail' => $this->getOrderProducts(),
        ];
    }

    private function getOrderProducts()
    {
        return OrderDetailResource::collection($this->detail);
    }

    private function getOrderStatus()
    {
        switch ($this->{Order::COL_STATUS}) {
            case 0:
                return 'Đã hủy';
            case 1:
                return 'Chờ xác nhận';
            case 2:
                return 'Đang chuẩn bị hàng';
            case 3:
                return 'Đang giao';
            case 4:
                return 'Đã nhận';
            default:
                return 'Đơn hàng gặp sự cố';
        }
    }
}
