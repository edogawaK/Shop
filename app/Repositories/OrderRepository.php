<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\DB;

class OrderRepository
{
    use Effects;

    const CANCEL_STATUS = 0;
    const PREPARE_STATUS = 1;
    const DELIVERY_STATUS = 2;
    const RECEIVE_STATUS = 3;

    public $pageSize = 10;

    public function getOrders($userId = null, $option = [])
    {
        if ($userId) {
            $query = User::find($userId)->orders();
        } else {
            $query = new Order();
        }
        $query = $this->attachFilter($query, $option['filters'] ?? null);
        $query = $this->attachSort($query, $option['sort'] ?? null, $option['sortMode'] ?? 'asc');

        $orders = $query->paginate($this->pageSize);
        return $orders;
    }

    public function getOrder($id, $userId)
    {
        $order = $this->getOrderModel($id);
        if ($userId) {
            if ($order->{Order::COL_USER} == $userId) {
                return $order;
            }
        } else {
            return $order;
        }
        throw new Error('Khong tim thay order ID: ' . $id);
    }

    public function storeOrder($order, $detail)
    {
        return DB::transaction(function () use ($order, $detail) {
            $productRepository = new ProductRepository();
            $cartRepository = new CartRepository();
            $order = Order::create($order);
            $total = 0;

            foreach ($detail as $detailItem) {
                $cart = $cartRepository->getCartModel($detailItem);
                $isAvailableProduct = $productRepository->isAvailable($cart->{Cart::COL_PRODUCT}, $cart->{Cart::COL_SIZE}, $cart->{Cart::COL_QUANTITY});

                if ($isAvailableProduct) {

                    $order->detail()->create([
                        OrderDetail::COL_ORDER => $order->{Order::COL_ID},
                        OrderDetail::COL_PRODUCT => $cart->{Cart::COL_PRODUCT},
                        OrderDetail::COL_SIZE => $cart->{Cart::COL_SIZE},
                        OrderDetail::COL_QUANTITY => $cart->{Cart::COL_QUANTITY},
                    ]);

                    $productRepository->updateQuantity($cart->{Cart::COL_PRODUCT}, $cart->{Cart::COL_SIZE}, $cart->{Cart::COL_QUANTITY}, ProductRepository::DECREASE_QUANTITY);
                    $product = Product::find($cart->{Cart::COL_PRODUCT});
                    $product->{Product::COL_SOLD} += $cart->{Cart::COL_QUANTITY};
                    $product->save();
                    $total += Product::find($cart->{Cart::COL_PRODUCT})->{Product::COL_PRICE} * $cart->{Cart::COL_QUANTITY};

                    $cart->delete();
                } else {
                    throw new Error('Không thể đặt hàng do không đủ số lượng');
                }
            }

            $order->{Order::COL_TOTAL} = $total;
            $order->save();
            return $order->fresh();
        });
    }

    public function cancelOrder($id)
    {
        $productRepository = new ProductRepository();
        DB::transaction(function () use ($productRepository, $id) {
            $order = Order::find($id);
            $order->{Order::COL_STATUS} = self::CANCEL_STATUS;
            $order->save();

            $detail = $order->detail;
            foreach ($detail as $detailItem) {
                $productRepository->updateQuantity($detailItem[OrderDetail::COL_PRODUCT], $detailItem[OrderDetail::COL_SIZE], $detailItem[OrderDetail::COL_QUANTITY], ProductRepository::INCREASE_QUANTITY);
                $product = Product::find($detailItem[OrderDetail::COL_PRODUCT]);
                $product->{Product::COL_SOLD} -= $detailItem[OrderDetail::COL_QUANTITY];
                $product->save();
            }
            return true;
        });
    }

    public function orderReceived($id)
    {
        $this->updateOrderStatus($id, self::RECEIVE_STATUS);
        return true;
    }

    public function orderPrepare($id)
    {
        $this->updateOrderStatus($id, self::PREPARE_STATUS);
        return true;
    }

    public function orderDelivery($id)
    {
        $this->updateOrderStatus($id, self::DELIVERY_STATUS);
        return true;
    }

    public function updateOrderStatus($id, $status)
    {
        $order = Order::find($id);
        $order->{Order::COL_STATUS} = $status;
        $order->save();
        return $order;
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
        $data = $user->join('order', User::COL_ID, '=', Order::COL_USER)
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
