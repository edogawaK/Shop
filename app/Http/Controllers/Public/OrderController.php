<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Order\StoreOrderRequest;
use App\Http\Resources\Public\OrderResource;
use App\Models\Order;
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
        $orders = $orderRepository->getOrders($request->user()->{User::COL_ID});
        return $this->response(['data' => OrderResource::collection($orders)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $orderRepository = new OrderRepository();
        $requestData = $request->convert();
        $user = $request->user();

        $orderData = [
            Order::COL_USER => $user->{User::COL_ID},
            Order::COL_LOCATE => $user->{User::COL_LOCATE},
        ];

        $detailData = $requestData['detail'];

        $order = $orderRepository->storeOrder($orderData, $detailData);

        return $this->response([
            'data' => new OrderResource($order->fresh()),
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

        $userId = Auth::user()->{User::COL_ID};
        $order = $orderRepository->getOrder($id, $userId);
        return $this->response([
            'data' => new OrderResource($order),
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
