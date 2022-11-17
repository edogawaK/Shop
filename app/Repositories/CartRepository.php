<?php

namespace App\Repositories;

use App\Http\Resources\Public\CartResource;
use App\Models\Cart;
use App\Models\User;
use Error;
use Exception;

class CartRepository
{
    protected $pageSize = 10;

    public function getCart($userId)
    {
        $userRepository=new UserRepository();
        $user=$userRepository->getUserModel($userId);
        $data = $user->carts;
        return $data;
    }

    public function addToCart($data)
    {
        $productRepository = new ProductRepository();
        $productAvailable = $productRepository->isAvailable($data[Cart::COL_PRODUCT], $data[Cart::COL_SIZE], $data[Cart::COL_QUANTITY]);
        if ($productAvailable) {
            return Cart::create($data);
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

    public function getCartModel($id){
        $cart=Cart::find($id);
        if($cart){
            return $cart;
        }
        throw new Error('Không tìm thấy cart có id: '.$id);
    }
}
