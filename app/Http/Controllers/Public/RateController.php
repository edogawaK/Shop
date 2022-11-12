<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use App\Models\User;
use App\Repositories\RateRepository;
use Illuminate\Http\Request;

class RateController extends Controller
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
    public function index(Request $request, $productId)
    {
        $rateRepository = new RateRepository();
        $rates = $rateRepository->getRates($productId);
        return $this->response(['data' => $rates]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productId)
    {
        $rateRepository = new RateRepository();
        $userId = $request->user()->{User::COL_ID};
        $orderId = $request->orderId;
        $data = [
            Rate::COL_CONTENT => $request->content,
            Rate::COL_POINT => $request->point,
        ];
        $result = $rateRepository->storeRate($userId, $orderId, $productId, $data);
        return $this->response(['data' => $result]);
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
    public function update(Request $request, $productId, $id)
    {
        $rateRepository = new RateRepository();
        $data = array_filter([
            Rate::COL_CONTENT => $request->content ?? null,
            Rate::COL_POINT => $request->point ?? null,
        ]);
        $result = $rateRepository->updateRate($id, $data);
        return $this->response(['data' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($productId, $id)
    {
        $rateRepository = new RateRepository();
        $result = $rateRepository->destroyRate($id);
        return $this->response(['data' => $result]);
    }
}
