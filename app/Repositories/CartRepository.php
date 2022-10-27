<?php

namespace App\Repositories;

use App\Http\Resources\Public\CartResource;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Size;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

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
        $productRepo = App::make(ProductRepository::class);
        $newQuantity = $productRepo->getQuantity($data[Product::COL_ID], $data[Cart::COL_SIZE]) - $data[Cart::COL_QUANTITY];

        if ($newQuantity >= 0) {
            $productRepo->update([
                Product::COL_ID => $data[Product::COL_ID],
                'quantity' => $newQuantity,
                'size' => $data[Cart::COL_SIZE],
            ]);
            return new CartResource($this->create($data));
        }
        throw new Exception('Khong du so luong');
    }

    public function removeFromCart($id)
    {
        DB::transaction(function () use ($id) {
            $cartItem = Cart::find($id);

            $product = $cartItem->{Product::COL_ID};
            $size = $cartItem->{Size::COL_ID};
            $quantity = $cartItem->{Cart::COL_QUANTITY};

            $productRepo = App::make(ProductRepository::class);
            $newQuantity = $productRepo->getQuantity($product, $size) + $quantity;

            $data = $productRepo->update([
                Product::COL_ID => $product,
                'quantity' => $newQuantity,
                'size' => $size,
            ]);

            $this->delete($id);
        });

        return true;
    }

    public function updateCart($data)
    {
        $cartItem = Cart::find($data[Cart::COL_ID]);
        $quantityInfo = $cartItem->product->size($cartItem->{Cart::COL_SIZE})->get()[0];
        if ($quantityInfo) {
            $change = $cartItem->{Cart::COL_QUANTITY}-$data[Cart::COL_QUANTITY];
            $quantityInfo->pivot->quantity += $change;
            if ($quantityInfo->pivot->quantity >= 0) {
                $quantityInfo->pivot->save();
            } else {
                throw new Exception("Khong du hang de update");
            }

            $cartItem->{Cart::COL_QUANTITY} = $data[Cart::COL_QUANTITY];
            $cartItem->save();
            return new CartResource($cartItem);
        }
        throw new Exception("KHONG TIM THAY THONG TIN SP TRONG CART");
    }
}
