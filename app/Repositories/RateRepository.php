<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Rate;

class RateRepository
{
    public function getAllByProduct($productId)
    {
        return Product::find($productId)->rates;
    }

    public function updateRate($id, $data)
    {
        return Rate::find($id)->update($data);
    }

    public function createRate($data)
    {
        return Rate::create($data);
    }

    public function deleteRate($id)
    {
        return Rate::find($id)->delete();
    }
}
