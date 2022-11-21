<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Requests\Private\Product\StoreProductRequest;
use App\Http\Requests\Private\Product\UpdateProductRequest;
use App\Http\Resources\Public\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private const SORT_PRICE = 'price';
    private const SORT_SOLD = 'sold';
    private const SORT_DATE = 'date';
    private const SORT_DESC = 'desc';
    private const SORT_ASC = 'asc';

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productRepository = new ProductRepository();
        $filterRules = $this->convertFilter($request);
        $sortRules = $this->convertSort($request);
        $products = $productRepository->getProducts([
            'filters' => $filterRules,
            'sort' => $sortRules['rules'],
            'sortMode' => $sortRules['mode'],
        ]);
        return $this->response([
            'data' => ProductResource::collection($products),
            'other' => [
                'total' => $products->total(),
            ],
        ]);
    }

    private function convertFilter(Request $request)
    {
        $filterRules = [];
        if ($request->category) {
            $filterRules[Category::COL_ID] = [Category::COL_ID, '=', $request->category];
        }
        if ($request->maxPrice) {
            $filterRules[Product::COL_PRICE] = [Product::COL_PRICE, '<=', $request->maxPrice];
        }
        if ($request->minPrice) {
            $filterRules[Product::COL_PRICE] = [Product::COL_PRICE, '>=', $request->minPrice];
        }
        return $filterRules;
    }

    private function convertSort(Request $request)
    {
        $sortRules = [
            'rules' => null,
            'mode' => null,
        ];
        if ($request->sort) {
            switch ($request->sort) {
                case self::SORT_PRICE:
                    $sortRules['rules'] = Product::COL_PRICE;
                    $sortRules['mode'] = $request->sortMode ?? self::SORT_ASC;
                    break;
                case self::SORT_DATE:
                    $sortRules['rules'] = Product::COL_DATE;
                    $sortRules['mode'] = $request->sortMode ?? self::SORT_ASC;
                    break;
                case self::SORT_SOLD:
                    $sortRules['rules'] = Product::COL_SOLD;
                    $sortRules['mode'] = $request->sortMode ?? self::SORT_ASC;
                    break;
            }
        }
        return $sortRules;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $productRepository = new ProductRepository();
        $requestData = $request->convert();
        $product = $productRepository->storeProduct($requestData);
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productRepository = new ProductRepository();
        $product = $productRepository->getProductModel($id);
        $product->detail = true;
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $productRepository = new ProductRepository();
        $requestData = $request->convert();
        $product = $productRepository->updateProduct($id, $requestData);
        return $this->response([
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateImages(Request $request, $id)
    {
        $productRepository = new ProductRepository();
        $requestData = $request->convert();
        // $product = $productRepository->updateImages($id, $requestData);
        // return $this->response(['data' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
