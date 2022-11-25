<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Image\StoreImageRequest;
use App\Models\Image;
use App\Models\Product;
use App\Repositories\ImageRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImageRequest $request)
    {
        $productRepository = new ProductRepository();
        $imageRepository = new ImageRepository();
        $requestData = $request->convert();

        $product = $productRepository->getProductModel($requestData[Image::COL_PRODUCT]);
        $image = $imageRepository->storeImage($requestData);
        if ($requestData['isAvatar']) {
            $product->{Product::COL_AVT} = $image->{Image::COL_ID};
            $product->save();
        }
        return $image;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $productRepository = new ProductRepository();
        $imageRepository = new ImageRepository();

        // $product = $productRepository->getProductModel($productId);
        // if ($product->{Product::COL_AVT} == $id) {
        //     $product->{Product::COL_AVT} = null;
        //     $product->save();
        // }

        $imageRepository->destroyImage($id);


        return $this->response([
            'data' => true,
        ]);
    }
}
