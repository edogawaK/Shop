<?php

namespace App\Repositories;

use App\Models\Image;
use App\Models\Product;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ImageRepoitory
{

    public function getImages($productId)
    {
        $images = Image::where(Image::COL_PRODUCT, $productId)->get();
        return $images;
    }

    public function getImage($id)
    {
        $image = $this->getImageModel($id);
        return $image;
    }

    public function storeImage($data)
    {
        $productRepoitory = new ProductRepository();
        $product = $productRepoitory->getProductModel($data[Image::COL_PRODUCT]);
        $this->uploadImage($data['image']);
        $image = $product->images()->create($data);
        return $image;
    }

    public function destroyImage($id)
    {
        $image = Image::find($id);
        Storage::disk('public')->delete('images/' . $image->{Image::COL_LINK});
    }

    public function uploadImage($image){
        $imageUrl = $image->store('images', 'public');
        return $imageUrl;
    }

    public function getImageModel($id)
    {
        $image = Image::find($id);
        if ($image) {
            return $image;
        }
        throw new Error('Image Not Found');
    }

    // public function getRatePoint($id){
    //     $product=$this->getProductModel($id);
    //     $rates=$product->rates()->count();
    //     return
    // }
}
