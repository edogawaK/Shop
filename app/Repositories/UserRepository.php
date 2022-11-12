<?php

namespace App\Repositories;

use App\Models\User;
use Error;
use Illuminate\Support\Facades\Auth;

class UserRepository
{
    public function getUserModel($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user;
        }
        throw new Error('User khong ton tai', 404);
    }

    public function signin($email, $password)
    {
        if (Auth::attempt([
            User::COL_EMAIL => $email,
            'password' => $password,
        ])) {
            $user = Auth::user();
            $token = $user->createToken($this->tokenName, $this->abilities)->plainTextToken;
            return UserResource($user);
        }
        throw new Error('Signin fail!');
    }

    public function signup($data)
    {

    }

    public function renderToken($id)
    {

    }
}
