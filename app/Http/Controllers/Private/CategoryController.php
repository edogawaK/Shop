<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Requests\Private\Category\StoreCategoryRequest;
use App\Http\Requests\Private\Category\UpdateCategoryRequest;
use App\Http\Requests\Public\Cart\StoreCartRequest;
use App\Http\Resources\Public\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:admin']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getCategories();
        return $this->response([
            'data' => CategoryResource::collection(Category::where(Category::COL_PARENT, '<>', NULL)->get()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $categoryRepository = new CategoryRepository();
        $requestData = $request->convert();
        $category = $categoryRepository->storeCategory([...$requestData, Category::COL_PARENT => 1]);
        return $this->response([
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categoryRepository = new CategoryRepository();
        $categories = $categoryRepository->getCategory($id);
        return $this->response([
            'data' => new CategoryResource($categories),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        $categoryRepository = new CategoryRepository();
        $requestData = $request->convert();
        $category = $categoryRepository->updateCategory($id, $requestData);
        return $this->response([
            'data' => new CategoryResource($category),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryRepository = new CategoryRepository();
        $result = $categoryRepository->destroyCategory($id);
        return $this->response([
            'data' => ($result),
        ]);
    }
}
