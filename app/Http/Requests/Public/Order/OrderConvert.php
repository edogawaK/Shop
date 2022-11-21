<?php

namespace App\Http\Requests\Public\Order;

use App\Models\Order;
use App\Models\OrderDetail;

trait OrderConvert
{
    public function convert()
    {
        return [
            'detail' => $this->detail,
        ];
    }
}
