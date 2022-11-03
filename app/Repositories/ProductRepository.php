<?php

namespace App\Repositories;

use App\Http\Resources\Public\ProductResource;
use App\Models\Product;
use App\Models\Size;
use Error;
use Exception;

class ProductRepository
{
    const UPDATE_QUANTITY = 'UPDATE_QUANTITY';
    const DECREASE_QUANTITY = 'DECREASE_QUANTITY';
    const INCREASE_QUANTITY = 'INCREASE_QUANTITY';

    private $pageSize=10;

    public function getProductDetail($id)
    {
        $product = Product::find($id);
        $product->sizes;
        $product->images;
        return new ProductResource($product);
    }

    public function getAll($options = ['filters' => [], 'sort' => null, 'sortMode' => null])
    {
        $query = new Product();

        if ($options['filters']) {
            foreach ($options['filters'] as $filter) {
                $query = $query->where(...$filter);
            }
        }

        if ($options['sort']) {
            $query = $query->orderBy($options['sort'], $options['sortMode']);
        }

        $data = $query->paginate($this->pageSize);

        return ProductResource::collection($data);
    }

    // public function isAvailableProduct($id)
    // {
    //     $sizes = Product::find($id)->sizes;

    //     foreach ($sizes as $size => $amount) {
    //         if ($amount > 0) {
    //             return true;
    //         }
    //     }

    //     return false;
    // }

    public function isAvailable(int $id, int $sizeId, int $quantity)
    {
        $currentQuantity = $this->getQuantity($id, $sizeId);
        $newQuantity = $currentQuantity - $quantity;
        return $newQuantity >= 0;
    }

    public function getQuantity(int $id, int $sizeId)
    {
        $product = $this->getProduct($id);
        $sizeInfo = $this->getSizeInfo($product, $sizeId);

        if ($sizeInfo) {
            return $sizeInfo->pivot->quantity;
        }
        throw new Exception('Product have not this Size');
    }

    public function updateProduct($id, $data)
    {
        $product = Product::find($id);

        $product->update($data);

        if ($data['quantity'] && $data['size']) {
            if (!$this->updateQuantity($data[Product::COL_ID], $data['size'], $data['quantity'])) {
                throw new Exception("khong the cap nhat sl");
            }
        }

        return true;
    }

    public function updateQuantity(int $id, int $sizeId, int $quantity, string $mode = self::UPDATE_QUANTITY)
    {
        $product = $this->getProduct($id);
        $sizeInfo = $this->getSizeInfo($product, $sizeId);

        switch ($mode) {
            case self::INCREASE_QUANTITY:
                $sizeInfo->pivot->quantity += $quantity;
                break;
            case self::DECREASE_QUANTITY:
                $sizeInfo->pivot->quantity -= $quantity;
                break;
            default:
                $sizeInfo->pivot->quantity = $quantity;
        }
        return $sizeInfo->pivot->save();
    }

    private function getProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            throw new Error('Không tìm thấy sản phẩm');
        }
        return $product;
    }

    private function getSizeInfo(Product $product, int $sizeId)
    {
        $sizeInfo = $product->size($sizeId)->get()[0];
        if (!$sizeInfo) {
            throw new Exception("KHONG TIM THAY THONG TIN SIZE");
        }
        return $sizeInfo;
    }
}
