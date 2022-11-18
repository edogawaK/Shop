<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Rate\StoreRateRequest;
use App\Http\Resources\Public\RateResource;
use App\Models\Rate;
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
        return $this->response(['data' => RateResource::collection($rates)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRateRequest $request, $id)
    {
        $rateRepository = new RateRepository();
        $requestData = $request->convert();
        $rate = $rateRepository->storeRate($requestData);
        return $this->response(['data' => new RateResource($rate)]);
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
