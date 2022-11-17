<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Size\StoreSizeRequest;
use App\Http\Resources\Public\SizeResource;
use App\Repositories\SizeRepository;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $productId)
    {
        $sizeRepository = new SizeRepository();
        $sizes = $sizeRepository->getSizes();
        return $this->response(['data' => SizeResource::collection($sizes)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeRequest $request)
    {
        $sizeRepository = new SizeRepository();
        $requestData = $request->convert();

        $size = $sizeRepository->storeSize($requestData);
        return $this->response([
            'data' => $size,
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
        $sizeRepository = new SizeRepository();
        $requestData = $request->convert();

        $result = $sizeRepository->updateSize($id, $requestData);
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
        $sizeRepository = new SizeRepository();
        $result=$sizeRepository->destroySize($id);
        return $this->response([
            'data'=>$result
        ]);
    }
}
