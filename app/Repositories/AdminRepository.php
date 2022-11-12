<?php

namespace App\Repositories;

use App\Http\Resources\Private\AdminResource;
use App\Models\Admin;

class AdminRepository
{
    protected $pageSize = 2;

    public function getAdmins()
    {
        $admins = Admin::paginate($this->$pageSize);
        return AdminResource::collection($admins);
    }

    public function getAdmin($id)
    {
        $admin = Admin::find($id);
        return new AdminResource($admin);
    }

    public function storeAdmin($data)
    {
        $admin = Admin::create($data);
        return new AdminResource($admin);
    }

    public function updateAdmin($id, $data)
    {
        $admin = Admin::find($id)->update($data);
        return new AdminResource($admin);
    }

    public function destroyAdmin($id)
    {
        Admin::find($id)->delete();
        return true;
    }
}
