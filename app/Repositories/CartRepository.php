<?php

namespace App\Repositories;

use App\Models\Cart;
use Error;
use Exception;

class CartRepository
{
    protected $pageSize = 10;

    public function getCart($userId)
    {
        $userRepository = new UserRepository();
        $user = $userRepository->getUserModel($userId);
        $data = $user->carts;
        return $data;
    }

    public function addToCart($params)
    {
        $productRepository = new ProductRepository();
        $productAvailable = $productRepository->isAvailable($params[Cart::COL_PRODUCT], $params[Cart::COL_SIZE], $params[Cart::COL_QUANTITY]);
        if ($productAvailable) {

            $cart = Cart::where(Cart::COL_USER, $params[Cart::COL_USER])
                ->where(Cart::COL_PRODUCT, $params[Cart::COL_PRODUCT])
                ->where(Cart::COL_SIZE, $params[Cart::COL_SIZE])->get()[0] ?? null;

            if ($cart) {
                $cart->{Cart::COL_QUANTITY} += $params[Cart::COL_QUANTITY];
                $cart->save();
            } else {
                $cart = Cart::create($params);
            }

            return $cart;
        }
        throw new Exception('Khong du so luong');
    }

    public function removeFromCart($id)
    {
        Cart::find($id)->delete();
        return true;
    }

    public function updateCart($id, $data)
    {
        $productRepository = new ProductRepository();
        $cartItem = $this->getCartModel($id);
        $productAvailable = $productRepository->isAvailable($cartItem->{Cart::COL_PRODUCT}, $cartItem->{Cart::COL_SIZE}, $data[Cart::COL_QUANTITY]);
        if ($productAvailable) {
            $cartItem->{Cart::COL_QUANTITY} = $data[Cart::COL_QUANTITY];
            $cartItem->save();
            return $cartItem;
        } else {
            throw new Exception("Khong du hang de update");
        }
        throw new Exception("KHONG TIM THAY THONG TIN SP TRONG CART");
    }

    public function getCartModel($id)
    {
        $cart = Cart::find($id);
        if ($cart) {
            return $cart;
        }
        throw new Error('Không tìm thấy cart có id: ' . $id);
    }
}
