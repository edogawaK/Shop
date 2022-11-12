<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        return $this->response(['data' => $orderRepository->getOrders($request->user()->{User::COL_ID})]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $orderRepository = new OrderRepository();
        $userID = $request->user()->{User::COL_ID};
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

        $data = $orderRepository->storeOrder($orderData, $detailData);

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
        $orderRepository = new OrderRepository();
        
        $data=$orderRepository->getOrder($id);
        return $this->response([
            'data'=>$data,
        ]);
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
