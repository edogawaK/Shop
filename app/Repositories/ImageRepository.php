<?php

namespace App\Repositories;

use App\Models\Image;
use Error;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use PharIo\Manifest\Url;

class ImageRepository
{
    const EXTERNAL_HOST='https://freeimage.host/api/1/upload';
    const EXTERNAL_KEY='6d207e02198a847aa98d0a2a901485a5';
    
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
        $url = $this->uploadImage($data['image']);
        $image = $product->images()->create([
            Image::COL_LINK => $url,
        ]);
        return $image;
    }

    public function destroyImage($id)
    {
        $image=Image::find($id);
        $image->delete();
        return true;
    }

    public function uploadImage($image)
    {
        // $sourceData=base64_encode(file_get_contents($image));
        $response=Http::attach('source', $image)->post(self::EXTERNAL_HOST, ['key'=>self::EXTERNAL_KEY])->json();
        return $response['image']['url'];
    }

    public function getImageModel($id)
    {
        $image = Image::find($id);
        if ($image) {
            return $image;
        }
        throw new Error('Image Not Found');
    }
}
