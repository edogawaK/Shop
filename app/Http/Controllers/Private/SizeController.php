<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Requests\Private\Size\StoreSizeRequest;
use App\Http\Requests\Private\Size\UpdateSizeRequest;
use App\Http\Resources\Public\SizeResource;
use App\Models\Size;
use App\Repositories\SizeRepository;
use Illuminate\Http\Request;

class SizeController extends Controller
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
        $sizeRepository = new SizeRepository();
        $sizes = $sizeRepository->getSizes();
        return $this->response([
            'data' => SizeResource::collection($sizes),
        ]);
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
            'data' => new SizeResource($size),
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
    public function update(UpdateSizeRequest $request, $id)
    {
        $sizeRepository = new SizeRepository();
        $requestData = $request->convert();

        $sizeRepository->updateSize($id, $requestData);
        $size=$sizeRepository->getSize($id);
        return $this->response([
            'data' => new SizeResource($size),
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
        $result = $sizeRepository->destroySize($id);
        return $this->response([
            'data' => $result,
        ]);
    }
}
