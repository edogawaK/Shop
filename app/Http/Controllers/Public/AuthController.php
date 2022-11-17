<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Auth\SigninRequest;
use App\Http\Requests\Public\Auth\SignupRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signin(SigninRequest $request)
    {
        $userRepository = new UserRepository();
        return $userRepository->signin($request->email, $request->password);
    }

    public function signup(SignupRequest $request)
    {
        $requestData = $request->convert();
        $userRepository = new UserRepository();
        $userRepository->signup($requestData);
        return $this->response();
    }

    public function forgot(Request $request)
    {
    }

    public function reset(Request $request)
    {

    }

    public function logout(Request $request)
    {
    }
}
