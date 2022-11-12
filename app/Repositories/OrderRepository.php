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
    public function getOrders($userId, $options = ['filters' => [], 'sort' => null, 'sortMode' => null])
    {
        $data = User::find($userId)->orders;

        return OrderResource::collection($data);
    }

    public function getOrder($id)
    {
        $order = Order::find($id);
        return new OrderResource($order);
    }

    public function storeOrder($order, $detail)
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

    public function isProductInOrder($id, $productId)
    {
        $order = $this->getOrderModel($id);
        $detail = $order->detail()->where(Product::COL_ID, $productId)->get();
        if (count($detail) > 0) {
            return true;
        }
        return false;
    }

    public function isBoughtProduct($userId, $productId)
    {
        $userRepository = new UserRepository();
        $user = $userRepository($userId);
        $data=$user->join('order', User::COL_ID, '=', Order::COL_USER)
            ->join('order_detail', OrderDetail::COL_ORDER, '=', Order::COL_ID)
            ->where(Product::COL_ID, $productId)
            ->get();
        return $data;
    }

    public function getOrderModel($id)
    {
        $order = Order::find($id);
        if ($order) {
            return $order;
        }
        throw new Error('Order khong ton tai', 404);
    }
}
