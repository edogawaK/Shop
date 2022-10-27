<?php

namespace App\Repositories;

use App\Http\Resources\Public\ProductResource;
use App\Models\Product;
use App\Models\Size;
use Exception;

class ProductRepository
{

    public function getDetail($id, $trict = false)
    {
        $product = Product::find($id);
        $product->sizes;
        $product->images;
        return new ProductResource($product);
    }

    public function all($options = ['filters' => [], 'sort' => null, 'sortMode' => null])
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

    public function isAvailable($id)
    {
        $sizes = Product::find($id)->sizes;

        foreach ($sizes as $size => $amount) {
            if ($amount > 0) {
                return true;
            }
        }

        return false;
    }

    public function getQuantity($id, $sizeID)
    {
        $tockInfo = Product::find($id)->size($sizeID)->get()[0];
        if ($tockInfo) {
            return $tockInfo->pivot->quantity;
        }
        throw new Exception('Product have not this Size');
    }

    public function update($data)
    {
        $product = Product::find($data[Product::COL_ID]);

        if (isset($data[Product::COL_CATEGORY])) {
            $product[Product::COL_CATEGORY] = $data[Product::COL_CATEGORY];
        }
        if (isset($data[Product::COL_COST])) {
            $product[Product::COL_COST] = $data[Product::COL_COST];
        }
        if (isset($data[Product::COL_DESC])) {
            $product[Product::COL_DESC] = $data[Product::COL_DESC];
        }
        if (isset($data[Product::COL_NAME])) {
            $product[Product::COL_NAME] = $data[Product::COL_NAME];
        }
        if (isset($data[Product::COL_PRICE])) {
            $product[Product::COL_PRICE] = $data[Product::COL_PRICE];
        }
        if (isset($data[Product::COL_SALE])) {
            $product[Product::COL_SALE] = $data[Product::COL_SALE];
        }
        if (isset($data[Product::COL_STATUS])) {
            $product[Product::COL_STATUS] = $data[Product::COL_STATUS];
        }
        if ($data['quantity'] && $data['size']) {
            if (!$this->updateQuantity($data[Product::COL_ID], $data['size'], $data['quantity'])) {
                throw new Exception("khong the cap nhat sl");
            }
        }

        return $product->save();
    }

    public function updateQuantity($id, $sizeID, $quantity)
    {
        $product = Product::find($id);
        if (!$product) {
            throw new Exception("KHONG_TIM_THAY_SP");
        }

        $sizeInfo = $product->size($sizeID)->get()[0];
        if (!$sizeInfo) {
            throw new Exception("KHONG TIM THAY THONG TIN SIZE");
        }

        $sizeInfo->pivot->quantity = $quantity;

        return $sizeInfo->pivot->save();
    }
}
