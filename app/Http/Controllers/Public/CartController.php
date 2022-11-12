<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Cart\StoreCartRequest;
use App\Http\Requests\Public\Cart\UpdateCartRequest;
use App\Models\User;
use App\Repositories\CartRepository;
use Illuminate\Http\Request;

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
        $cartRepository = new CartRepository();
        return $this->response(['data' => $cartRepository->getCart($request->user()->user_id)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        $cartRepository = new CartRepository();
        $requestData = $request->convert();
        $requestData[User::COL_ID]=$request->user()->{User::COL_ID};
        $result = $cartRepository->addToCart($requestData);

        return $this->response([
            'data' => $result,
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
    public function update(UpdateCartRequest $request, $id)
    {
        $cartRepository = new CartRepository();
        $requestData = $request->convert();

        $result = $cartRepository->updateCart($requestData);

        return $this->response([
            'data' => $result,
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
        $cartRepository = new CartRepository();

        $result = $cartRepository->removeFromCart($id);

        return $this->response([
            'data' => $result,
        ]);
    }
}
