<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->response(['data' => app('CartRepository')->all($request->user()->user_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CartRequest $request)
    {
        $data = app('CartRepository')->addToCart(
            [
                Cart::COL_USER => $request->user()->user_id,
                Cart::COL_PRODUCT => $request['product'],
                Cart::COL_SIZE => $request['size'],
                Cart::COL_QUANTITY => $request['quantity'],
            ]);
        $product = Product::find(1);

        return $this->response([
            'data' => $data,
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
        $data = array_filter([
            Cart::COL_ID=>$id,
            Cart::COL_QUANTITY => $request->quantity ?? null,
            Cart::COL_SIZE => $request->size ?? null,
        ]);

        return $this->response([
            'data' => app('CartRepository')->updateCart($data),
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
        $cartRepo = App::make(CartRepository::class);
        $data = $cartRepo->removeFromCart($id);

        return $this->response([
            'data' => $data,
        ]);
    }
}
