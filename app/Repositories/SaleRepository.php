<?php

namespace App\Repositories;

use App\Http\Resources\Public\SaleResource;
use App\Models\Product;
use App\Models\Sale;
use Error;

class SaleRepository
{
    public $pageSize = 10;
    const PERCENTAGE_UNIT = 'percentage';
    const MONEY_UNIT = 'vnd';
    const BASE_UNIT = 'base';

    public function getSales()
    {
        $sales = Sale::paginate($this->pageSize);

        return SaleResource::collection($sales);
    }

    public function getSale($id)
    {
        $sale = $this->getSaleModel($id);
        $sale->products = $sale->products()->paginate($this->$this->pageSize);
        return new SaleResource($sale);
    }

    public function storeSale($data)
    {
        $sale = Sale::create($data);
        if ($data['products']) {
            foreach ($data['products'] as $product) {
                $this->addProduct($sale->{Sale::COL_ID}, $product);
            }
        }
        return $sale;
    }

    public function updateSale($id, $data)
    {
        Sale::find($id)->update($data);
        $sale = Sale::find($id);
        if ($data['removeProducts']) {
            foreach ($data['removeProducts'] as $product) {
                $this->removeProduct($product);
            }
        }
        if ($data['addProducts']) {
            foreach ($data['products'] as $product) {
                $this->addProduct($sale->{Sale::COL_ID}, $product);
            }
        }
        return $sale;
    }

    public function addProduct($id, $productId)
    {
        $productRepository = new ProductRepository();
        $product = $productRepository->getProductModel($productId);
        $product->{Product::COL_SALE} = $id;
        $product->save();
        return true;
    }

    public function removeProduct($productId)
    {
        $productRepository = new ProductRepository();
        $product = $productRepository->getProductModel($productId);
        $product->{Product::COL_SALE} = null;
        $product->save();
        return true;
    }

    public function getSaleModel($id)
    {
        $sale = Sale::find($id);
        if ($sale) {
            return new SaleResource($sale);
        }
        throw new Error("Không tìm thấy sale với id: " . $id);
    }

    public function getSalePrice($productId)
    {
        $productRepository = new ProductRepository();
        $product = $productRepository->getProductModel($productId);

        $sale = $product->sale;
        $price = $product->{Product::COL_PRICE};
        $salePrice = null;

        if ($sale) {
            $saleUnit = $sale->{Sale::COL_UNIT};
            $saleDiscount = $sale->{Sale::COL_DISCOUNT};
            switch ($saleUnit) {
                case self::BASE_UNIT:
                    $salePrice = $saleDiscount;
                    return $salePrice;
                case self::MONEY_UNIT:
                    $salePrice = $price - $saleDiscount;
                    return $salePrice;
                case self::PERCENTAGE_UNIT:
                    $salePrice = (1 - $saleDiscount / 100) * $price;
                    return $salePrice;
                default:
                    break;
            }
        }
        return $price;
    }
}
