<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Repositories\AdminRepository;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(){
        $adminRepository=new AdminRepository();
        $adminRepository->getAdmins([]);
    }
}
