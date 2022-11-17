<?php

namespace App\Repositories;

use App\Http\Resources\Public\UserResource;
use App\Models\Locate;
use App\Models\User;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class UserRepository
{
    public $tokenName = 'user_token';
    public $abilities = ['user'];
    public $pageSize = 10;

    public function getUsers()
    {
        $users = User::paginate($this->pageSize);
        return UserResource::collection($users);
    }

    public function getUser($id)
    {
        $user = $this->getUserModel($id);
        return new UserResource($user);
    }

    public function updateUser($id, $data)
    {
        $user = User::find($id)->update($data);
        return new UserResource($user);
    }

    public function storeUser($data)
    {
        $user = User::create($data);
        return new UserResource($user);
    }

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
            $user->token = $user->createToken($this->tokenName, $this->abilities)->plainTextToken;
            return new UserResource($user);
        }
        throw new Error('Signin fail!');
    }

    public function signup($data)
    {
        DB::transaction(function () use ($data) {
            try {
                $data[User::COL_PASSWORD] = bcrypt($data[User::COL_PASSWORD]);
                $data[Locate::COL_RECEIVER] = $data[User::COL_NAME];
                
                $locate = Locate::create($data);
                $data[Locate::COL_ID] = $locate->{Locate::COL_ID};
                $user = $this->storeUser($data);
            } catch (Throwable $error) {
                throw new Error('Đăng ký không thành công');
            }
            return true;
        });
    }

    public function renderToken($id)
    {

    }
}
