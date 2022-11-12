<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\Public\Auth\SigninRequest;
use App\Http\Requests\Public\Auth\SignupRequest;
use App\Models\Locate;
use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public $tokenName = 'user_token';
    public $abilities = ['user'];

    public function signin(SigninRequest $request)
    {
        $requestData = $request->convert();
        var_dump($requestData);
        if (Auth::attempt([
            User::COL_EMAIL => $requestData[User::COL_EMAIL],
            'password' => $requestData[User::COL_PASSWORD],
        ])) {
            return Auth::user()->tokens;
            // $token = $request->user()->createToken($this->tokenName, $this->abilities)->plainTextToken;

            // return $this->response([
            //     'message' => 'Signin success!',
            //     'data' => ['token' => $token],
            // ]);
        }
        throw new Error('Signin fail!');
    }

    public function signup(SignupRequest $request)
    {
        $data = $request->convert();
        DB::transaction(function () use ($data, $request) {
            $locate = Locate::create([...$data, 'receiver' => $request->name]);
            $user = User::create([...$data, 'locate_id' => $locate->locate_id]);
        });
        return $this->response(['message' => 'Signup success!']);
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
