<?php

namespace App\Http\Controllers\Private;

use App\Http\Controllers\Controller;
use App\Http\Requests\Private\Auth\SigninRequest;
use App\Repositories\AdminRepository;

class AuthController extends Controller
{
    public function signin(SigninRequest $request)
    {echo 'ok';
        $adminRepository = new AdminRepository();
        $admin = $adminRepository->signin($request->email, $request->password);
        return $this->response([
            'data' => $admin,
        ]);
    }
}
