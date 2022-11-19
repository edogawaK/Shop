<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Rate;
use Error;

class RateRepository
{
    public $pageSize = 10;

    public function getRates($productId)
    {
        $rates = Product::find($productId)->rates()->paginate($this->pageSize);
        return $rates;
    }

    public function updateRate($id, $data)
    {
        $rate = Rate::find($id)->update($data);
        return $rate;
    }

    public function storeRate($data)
    {
        $userId = $data[Rate::COL_USER];
        $productId = $data[Rate::COL_PRODUCT];

        if ($this->canRate($userId, $productId)) {
            $rate = Rate::create($data);
            return $rate;
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
        return ($user->orders()->where(Order::COL_STATUS, OrderRepository::RECEIVE_STATUS)->whereHas('detail', function ($query) use ($productId) {
            $query->where(OrderDetail::COL_PRODUCT, $productId);
        })->exists() && !$this->isRated($userId, $productId));
    }
}
