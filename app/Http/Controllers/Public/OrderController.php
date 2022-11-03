<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
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
        $orderRepository = new OrderRepository();
        return $this->response(['data' => $orderRepository->getAllByUser($request->user()->{User::COL_ID})]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userID = $request->user()->{User::COL_ID};
        $orderRepository = new OrderRepository();
        $orderData = [
            Order::COL_USER => $request->user()->{User::COL_ID},
            Order::COL_LOCATE => $request['locateId'],
        ];

        $detailData = [];

        foreach ($request['detail'] as $detailItem) {
            $detailData[] = [
                OrderDetail::COL_QUANTITY => $detailItem['quantity'],
                OrderDetail::COL_PRODUCT => $detailItem['productId'],
                OrderDetail::COL_SIZE => $detailItem['sizeId'],
            ];
        }

        $data = $orderRepository->createOrder($orderData, $detailData);

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
        $orderRepository = new OrderRepository();
        $orderRepository->cancelOrder($id);
        return $this->response(['data' => true]);
    }
}
