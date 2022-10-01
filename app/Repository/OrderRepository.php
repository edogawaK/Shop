<?php

namespace App\Repository;

use App\Models\Product;

class OrderRepository
{
    private $productModel;

    function __construct(Product $productModel)
    {
        $this->productModel = $productModel;
    }

    function getAll(){
        return $this->productModel->all();
    }

    function get($productId){
        return $this->productModel->find($productId);
    }

    function create($data){
        return $this->productModel->create($data);
    }

    function update($data){
        return $this->productModel->update($data);
    }

    function delete($productId){
        return $this->productModel->find(->update(['status$productId);
    }
}
