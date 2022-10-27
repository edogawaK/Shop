<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private const SORT_PRICE = 'price';
    private const SORT_SOLD = 'sold';
    private const SORT_DATE = 'date';
    private const SORT_DESC = 'desc';
    private const SORT_ASC = 'asc';
    private const PRICE = 'product_price';
    private const DATE = 'product_date';
    private const SOLD = 'product_sold';

    private $filters = [];
    private $sort = null;
    private $sortMode = SORT_ASC;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->attachFilter($request);
        $this->attachSort($request);
        return app('ProductRepository')->all([
            'filters'=>$this->filters,
            'sort'=>$this->sort,
            'sortMode'=>$this->sortMode,
        ]);
    }

    private function attachFilter(Request $request)
    {
        if ($request->category) {
            $this->filters[] = ['category_id', '=', $request->category];
        }
        if ($request->maxPrice) {
            $this->filters[] = ['product_price', '<=', $request->maxPrice];
        }
        if ($request->minPrice) {
            $this->filters[] = ['product_price', '>=', $request->minPrice];
        }
    }

    private function attachSort(Request $request)
    {
        if ($request->sort) {
            switch ($request->sort) {
                case $this->SORT_PRICE:
                    $this->sort = $this->PRODUCT_PRICE;
                    $this->sortMode = $request->sortMode ?? $this->SORT_ASC;
                    break;
                case $this->SORT_DATE:
                    $this->sort = $this->PRODUCT_PRICE;
                    $this->sortMode = $request->sortMode ?? $this->SORT_ASC;
                    break;
                case $this->SORT_SOLD:
                    $this->sort = $this->PRODUCT_PRICE;
                    $this->sortMode = $request->sortMode ?? $this->SORT_ASC;
                    break;
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->response(
            ['data' => app('ProductRepository')->getDetail($id)]
        );
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
        //
    }
}
