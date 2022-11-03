<?php

namespace App\Repositories;

use App\Http\Resources\Public\OrderResource;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\DB;

class OrderRepository
{

    public function all($options = ['filters' => [], 'sort' => null, 'sortMode' => null])
    {
        $query = $this->model;

        if ($options['filters']) {
            foreach ($options['filters'] as $filter) {
                $query = $query->where(...$filter);
            }
        }

        if ($options['sort']) {
            $query = $query->orderBy($options['sort'], $options['sortMode']);
        }

        $data = $query->paginate($this->pageSize);

        return Order::collection($data);
    }

    public function getAllByUser($userID)
    {
        return User::find($userID)->orders;
    }

    public function createOrder($order, $detail)
    {
        return DB::transaction(function () use ($order, $detail) {
            $productRepository = new ProductRepository();
            $order = Order::create($order);
            $total = 0;
            foreach ($detail as $detailItem) {
                $isAvailableProduct = $productRepository->isAvailable($detailItem[OrderDetail::COL_PRODUCT], $detailItem[OrderDetail::COL_SIZE], $detailItem[OrderDetail::COL_QUANTITY]);
                if ($isAvailableProduct) {
                    $order->detail()->create($detailItem);
                    $productRepository->updateQuantity($detailItem[OrderDetail::COL_PRODUCT], $detailItem[OrderDetail::COL_SIZE], $detailItem[OrderDetail::COL_QUANTITY], ProductRepository::DECREASE_QUANTITY);
                    $total += Product::find($detailItem[OrderDetail::COL_PRODUCT])->{Product::COL_PRICE};
                } else {
                    throw new Error('Không thể đặt hàng do không đủ số lượng');
                }
            }
            return new OrderResource($order);
        });
    }

    public function cancelOrder($id)
    {
        $productRepository = new ProductRepository();
        DB::transaction(function () use ($productRepository, $id) {
            $order = Order::find($id);
            $order->{Order::COL_STATUS} = -1;
            $order->save();

            $detail = $order->detail;
            foreach ($detail as $detailItem) {
                $productRepository->updateQuantity($detailItem[OrderDetail::COL_PRODUCT], $detailItem[OrderDetail::COL_SIZE], $detailItem[OrderDetail::COL_QUANTITY], ProductRepository::INCREASE_QUANTITY);
            }
            return true;
        });
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::find($id);
        $order->{Order::COL_STATUS} = $status;
        $order->save();
        return new OrderResource($order);
    }

    public function createOrderFromCart($data)
    {
        // +$cartRepository=new CartRepository();

    }
}
