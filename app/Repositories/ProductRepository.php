<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    use Effects;

    const UPDATE_QUANTITY = 'UPDATE_QUANTITY';
    const DECREASE_QUANTITY = 'DECREASE_QUANTITY';
    const INCREASE_QUANTITY = 'INCREASE_QUANTITY';

    private $pageSize = 12;

    public function getProductDetail($id)
    {
        $product = Product::find($id);
        $product->sizes;
        $product->images;
        return $product;
    }

    public function getProducts($option)
    {
        $query = new Product();
        $query = $query->where(Product::COL_STATUS, 1);
        $query = $this->attachFilter($query, $option['filters'] ?? null);
        $query = $this->attachSort($query, $option['sort'] ?? null, $option['sortMode'] ?? 'asc');

        $products = $query->paginate($this->pageSize);
        return $products;
    }

    public function storeProduct($data)
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create($data);
            $imageReposiory = new ImageRepository();
            foreach ($data['sizes'] as $size) {
                $product->sizes()->attach($size[Size::COL_ID], ['quantity' => $size['quantity']]);
            }

            foreach ($data['images'] as $image) {
                $imageReposiory->storeImage([
                    Image::COL_PRODUCT => $product->{Product::COL_ID},
                    'image' => $image,
                ]);
            }

            return $product;
        });
        throw new Error('Không thể ');
    }

    public function updateProduct($id, $data)
    {
        return DB::transaction(function () use ($data, $id) {
            $product = Product::find($id);

            $product->update($data);

            if ($data['sizes']) {
                foreach ($data['sizes'] as $size) {
                    if ($size['quantity'] && $size[Size::COL_ID]) {
                        if (!$this->updateQuantity($id, $size[Size::COL_ID], $size['quantity'])) {
                            throw new Exception("khong the cap nhat sl");
                        }
                    }
                }
            } else {
                if ($data['quantity'] && $data['size']) {
                    if (!$this->updateQuantity($id, $data['size'], $data['quantity'])) {
                        throw new Exception("khong the cap nhat sl");
                    }
                }
            }

            return $product->fresh();
        });
    }

    public function getQuantityTotal($id)
    {
        $product = $this->getProductModel($id);
        $sizeInfo = $product->sizes;
        $total = 0;
        foreach ($sizeInfo as $size) {
            $total += $size->pivot->quantity;
        }
        return $total;
    }

    public function isRunOut(Product $product)
    {
        $sizes = $product->sizes;

        foreach ($sizes as $size => $amount) {
            if ($amount > 0) {
                return false;
            }
        }

        $product->status = 0;
        $product->save();
        return true;
    }

    public function isAvailable(int $id, int $sizeId, int $quantity)
    {
        $currentQuantity = $this->getQuantity($id, $sizeId);
        $newQuantity = $currentQuantity - $quantity;
        return $newQuantity >= 0;
    }

    public function getQuantity(int $id, int $sizeId)
    {
        $product = $this->getProductModel($id);
        $sizeInfo = $this->getSizeInfo($product, $sizeId);

        if ($sizeInfo) {
            return $sizeInfo->pivot->quantity;
        }
        throw new Exception('Product have not this Size');
    }

    public function updateQuantity(int $id, int $sizeId, int $quantity, string $mode = self::UPDATE_QUANTITY)
    {
        $product = $this->getProductModel($id);
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
        $sizeInfo->pivot->update_at = date('Y-m-d H:i:s');
        return $sizeInfo->pivot->save();
    }

    public function getProductModel($id)
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

    // public function uploadImage($productId, $image)
    // {
    //     $imageUrl = $image->store('images', 'public');
    //     $imageModel = Image::create([
    //         Image::COL_LINK => $image,
    //         Image::COL_PRODUCT => $productId,
    //     ]);
    //     return $imageModel->{Image::COL_ID};
    // }

    // public function getRatePoint($id){
    //     $product=$this->getProductModel($id);
    //     $rates=$product->rates()->count();
    //     return
    // }
}
