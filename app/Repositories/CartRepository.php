<?php

namespace App\Repositories;

use App\Http\Resources\Public\CartResource;
use App\Models\Cart;
use App\Models\User;
use Exception;

class CartRepository
{
    protected $pageSize = 2;

    public function getCart($userId)
    {
        $data = User::find($userId)->carts;
        return CartResource::collection($data);
    }

    public function addToCart($data)
    {
        $productRepository = new ProductRepository();
        $productAvailable = $productRepository->isAvailable($data[Cart::COL_PRODUCT], $data[Cart::COL_SIZE], $data[Cart::COL_QUANTITY]);
        if ($productAvailable) {
            return new CartResource(Cart::create($data));
        }
        throw new Exception('Khong du so luong');
    }

    public function removeFromCart($id)
    {
        Cart::find($id)->delete();
        return true;
    }

    public function updateCart($data)
    {
        $productRepository = new ProductRepository();
        $cartItem = Cart::find($data[Cart::COL_ID]);
        $productAvailable = $productRepository->isAvailable($cartItem->{Cart::COL_PRODUCT}, $cartItem->{Cart::COL_SIZE}, $data[Cart::COL_QUANTITY]);
        if ($productAvailable) {
            $cartItem->{Cart::COL_QUANTITY} = $data[Cart::COL_QUANTITY];
            $cartItem->save();
            return new CartResource($cartItem);
        } else {
            throw new Exception("Khong du hang de update");
        }
        throw new Exception("KHONG TIM THAY THONG TIN SP TRONG CART");
    }
}
