<?php

namespace App\Repositories;

use App\Models\Admin;
use Error;
use Illuminate\Support\Facades\Auth;

class AdminRepository
{
    public $pageSize = 10;
    public $tokenName = 'admin_token';
    public $abilities = ['admin'];

    public function getAdmins()
    {
        $admins = Admin::paginate($this->pageSize);
        return $admins;
    }

    public function getAdmin($id)
    {
        $admin = $this->getAdminModel($id);
        return $admin;
    }

    public function storeAdmin($data)
    {
        $admin = Admin::create($data);
        return $admin;
    }

    public function updateAdmin($id, $data)
    {
        $admin=$this->getAdminModel($id);
        $admin->update($data);
        return $admin;
    }

    public function destroyAdmin($id)
    {
        Admin::find($id)->delete();
        return true;
    }

    public function getAdminModel($id){
        $admin=Admin::find($id);
        if($admin){
            return $admin;
        }
        throw new Error('Không tìm thấy admin có id: '.$id);
    }

    public function signin($email, $password)
    {
        if (Auth::guard('admin')->attempt([Admin::COL_EMAIL => $email, 'password' => $password])) {
            $admin = Auth::guard('admin')->user();
            $admin->token = $admin->createToken($this->tokenName, $this->abilities)->plainTextToken;
            return $admin;
        }
        throw new Error('Đăng nhập không thành công!');
    }
}
