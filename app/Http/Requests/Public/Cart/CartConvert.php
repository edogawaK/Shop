<?php

namespace App\Http\Requests\Public\Cart;

use App\Models\Cart;

trait CartConvert
{
    public function convert()
    {
        return array_filter([
            Cart::COL_PRODUCT => $this->productId,
            Cart::COL_SIZE => $this->sizeId,
            Cart::COL_QUANTITY => $this->quantity,
        ]);
    }
}
