<?php

namespace App\Repositories;

use App\Models\Size;
use Error;

class SizeRepository
{
    public $pageSize = 10;
    public function getSizes()
    {
        return Size::paginate($this->pageSize);
    }

    public function getSize($id)
    {
        return $this->getSizeModel($id);
    }

    public function storeSize($data)
    {
        return Size::create($data);
    }

    public function updateSize($id, $data)
    {
        $size=$this->getSizeModel($id);
        return $size->update($data);
    }

    public function destroySize($id)
    {
        $size=$this->getSizeModel($id);
        return $size->delete();
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
