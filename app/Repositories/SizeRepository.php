<?php

namespace App\Repositories;

use App\Http\Resources\Public\SizeResource;
use App\Models\Size;
use Error;

class SizeRepository
{
    public $pageSize = 10;
    public function getSizes()
    {
        $sizes = Size::paginate($this->pageSize);
        return SizeResource::collection($sizes);
    }
    public function getSize($id)
    {
        $size = Size::find($id);
        return new SizeResource($size);
    }
    public function storeSize($data)
    {
        $size = Size::create($data);
        return new SizeResource($size);
    }
    public function updateSize($id, $data)
    {
        $size = Size::find($id)->update($data);
        return new SizeResource($size);
    }
    public function destroySize($id)
    {
        $result = Size::find($id)->delete();
        return true;
    }
    public function getSizeModel($id)
    {
        $size = Size::find($id);
        if ($size) {
            return $size;
        }
        throw new Error('Không tìm thấy size có id: ' . $id);
    }
}
