<?php

namespace App\Repositories;

use App\Http\Resources\Public\CartResource;
use App\Models\Cart;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\App;

class CartRepository
{
    protected $pageSize = 2;

    public function all($userId)
    {
        $data = User::find($userId)->carts;
        return CartResource::collection($data);
    }

    private function create($data)
    {
        return Cart::create($data);
    }

    public function update($id, $data)
    {
        return Cart::find($id)->update($data);
    }

    public function delete($id)
    {
        return Cart::find($id)->delete();
    }

    public function addToCart($data)
    {
        $productRepository = new ProductRepository();
        $productAvailable = $productRepository->isAvailable($data[Cart::COL_PRODUCT], $data[Cart::COL_SIZE], $data[Cart::COL_QUANTITY]);
        if ($productAvailable) {
            return new CartResource($this->create($data));
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
