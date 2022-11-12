<?php

namespace App\Repositories;

use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Rate;
use Error;

class RateRepository
{
    public function getRates($productId)
    {
        return Product::find($productId)->rates;
    }

    public function updateRate($id, $data)
    {
        echo 'rate:' . $id;
        return Rate::find($id)->update($data);
    }

    public function storeRate($userId, $productId, $data)
    {
        if ($this->canRate($userId, $productId)) {
            return Rate::create($data);
        }
        throw new Error('Không thể thêm đánh giá!', 400);
    }

    public function destroyRate($id)
    {
        return Rate::find($id)->delete();
    }

    public function isRated($userId, $productId)
    {
        $rate = Rate::where(Rate::COL_USER, $userId)->where(Rate::COL_PRODUCT, $productId)->get();
        return $rate[0] ?? null;
    }

    public function canRate($userId, $productId)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserModel($userId);
        return $user->orders()->whereHas('detail', function ($query) use ($productId) {
            $query->where(OrderDetail::COL_PRODUCT, $productId);
        })->exists() && !$this->isRated($userId, $productId);
    }
}
