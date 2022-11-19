<?php

namespace App\Http\Controllers\Public;

use App\Exceptions\ExceptionList\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Auth\SigninRequest;
use App\Http\Requests\Public\Auth\SignupRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Error;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'abilities:verify'])->only(['verifyEmail', 'resetPassword']);
        $this->middleware(['auth:sanctum', 'abilities:user'])->only(['logout']);
    }

    public function signin(SigninRequest $request)
    {
        $userRepository = new UserRepository();
        return $this->response(['data' => $userRepository->signin($request->email, $request->password)]);
    }

    public function signup(SignupRequest $request)
    {
        $requestData = $request->convert();
        $userRepository = new UserRepository();
        $result = $userRepository->signup($requestData);
        return $this->response([
            'data' => $result,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $user = $request->user();
        $userRepository = new UserRepository();

        $accessToken = $userRepository->resetPassword($user, $request->password);

        if ($accessToken) {
            return $this->response([
                'data' => ['token' => $accessToken],
            ]);
        }

        throw new Error(...AuthException::ForgotFail);
    }

    public function forgotPassword(Request $request)
    {
        $userRepository = new UserRepository();
        $userRepository->forgotPassword($request->email);
        return $this->response([]);
    }

    public function verifyAccount(Request $request)
    {
        $user = $request->user();
        $userRepository = new UserRepository();

        $accessToken = $userRepository->verify($user);

        if ($accessToken) {
            return $this->response([
                'data' => ['token' => $accessToken],
            ]);
        }

        throw new Error(...AuthException::VerifyFail);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $userRepository = new UserRepository();
        $result = $userRepository->logout($user);
        return $this->response([
            'data' => $result,
        ]);
    }
}
