<?php

namespace App\Http\Requests\Public\Order;

use App\Models\Order;
use App\Models\OrderDetail;

trait OrderConvert
{
    public function convert()
    {
        return [
            Order::COL_LOCATE => $this->locateId,
            'detail' => array_map(function ($detail) {
                $data = [];
                $data[OrderDetail::COL_PRODUCT] = $detail['productId'];
                $data[OrderDetail::COL_SIZE] = $detail['sizeId'];
                $data[OrderDetail::COL_QUANTITY] = $detail['quantity'];
                return $data;
            }, $this->detail),
        ];
    }
}
