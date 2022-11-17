<?php

namespace App\Http\Requests\Private\Product;

use App\Models\Product;
use App\Models\Size;

trait ProductConvert
{
    public function convert()
    {
        return array_filter([
            Product::COL_NAME => $this->name,
            Product::COL_CATEGORY => $this->categoryId,
            Product::COL_COST => $this->cost,
            Product::COL_DESC => $this->desc,
            Product::COL_PRICE => $this->price,
            Product::COL_SALE => $this->saleId,
            'images'=>$this->images,
            'sizes' => array_map(function ($item) {
                return [
                    Size::COL_ID => $item['id'],
                    'quantity' => $item['quantity'],
                ];
            }, $this->sizes),
        ]);
    }
}
