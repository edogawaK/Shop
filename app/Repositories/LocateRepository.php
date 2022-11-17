<?php

namespace App\Repositories;

use App\Models\Locate;
use Error;

class LocateRepository
{
    public $pageSize = 10;

    public function getLocates()
    {
        $locates = Locate::paginate($this->pageSize);
        return $locates;
    }

    public function getLocate($id)
    {
        $locate = $this->getLocateModel($id);
        return $locate;
    }

    public function storeLocate($data)
    {
        $locate = Locate::create($data);
        return $locate;
    }

    public function updateLocate($id, $data)
    {
        $locate = Locate::find($id)->update($data);
        return $locate;
    }

    public function destroyLocate($id)
    {
        Locate::find($id)->delete();
        return true;
    }

    public function getLocateModel($id)
    {
        $locate = Locate::find($id);
        if ($locate) {
            return $locate;
        }
        throw new Error('Không tìm thấy');
    }
}
