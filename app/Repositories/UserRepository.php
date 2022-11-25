<?php

namespace App\Repositories;

use App\Exceptions\ExceptionList\AuthException;
use App\Exceptions\ExceptionList\UserException;
use App\Http\Resources\Public\UserResource;
use App\Mail\AuthMail;
use App\Models\Locate;
use App\Models\User;
use const App\Exceptions\AuthException;
use Error;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserRepository
{
    use Effects;

    public $tokenName = 'user_token';
    public $tokenVerify = 'verify_token';
    public $abilityVerify = ['verify'];
    public $abilities = ['user'];
    public $pageSize = 10;

    public function getUsers($option)
    {
        $query = new User();

        $query = $this->attachFilter($query, $option['filters'] ?? null);
        $query = $this->attachSort($query, $option['sort'] ?? null, $option['sortMode'] ?? 'asc');

        $users = User::paginate($this->pageSize);
        return $users;
    }

    public function getUser($id)
    {
        $user = $this->getUserModel($id);
        return $user;
    }

    public function updateUser($id, $params)
    {
        $user = User::find($id)->update($params);
        return $user;
    }

    public function storeUser($params)
    {
        $user = User::create($params);
        return new UserResource($user);
    }

    public function getUserModel($id)
    {
        $user = User::find($id);
        if ($user) {
            return $user;
        }
        throw new Exception(...UserException::NotFound);
    }

    public function getProfile($id)
    {
        // $user=$this->getUserModel($id);
        // if($user->{User::COL_STATUS}==0){
        //     $this->get
        // }
    }

    public function signin($email, $password)
    {
        if (Auth::attempt([
            User::COL_EMAIL => $email,
            'password' => $password,
        ])) {
            $user = Auth::user();
            if ($user->{User::COL_STATUS} == 1) {
                $user->token = $user->createToken($this->tokenName, $this->abilities)->plainTextToken;
                return new UserResource($user);
            }
            throw new Error(...AuthException::NotVerify);
        }
        throw new Error(...AuthException::SiginFail);
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
                $tokenVerify = $user->createToken($this->tokenVerify, $this->abilityVerify)->plainTextToken;

                $this->sendEmailVerify($user->{User::COL_EMAIL}, $tokenVerify, 'http://localhost:3000/verify-email');
            } catch (\Illuminate\Database\QueryException $e) {

                $errorCode = $e->errorInfo[1];
                if ($errorCode == 1062) {
                    throw new Error(...UserException::EmailExisted);
                }
                throw new Error(...AuthException::SignupFail);
            }

            return true;
        });
    }

    public function logout($user)
    {
        return $user->currentAccessToken()->delete();
        return true;
    }

    public function resetPassword($user, $password)
    {
        $accessToken = $this->verify($user);
        if ($accessToken) {
            $user->{User::COL_PASSWORD} = bcrypt($password);
            $user->save();
            return $accessToken;
        }
        return null;
    }

    public function forgotPassword($email)
    {
        $user = User::where(User::COL_EMAIL, $email)->get()[0];
        if ($user) {
            $tokenVerify = $user->createToken($this->tokenVerify, $this->abilityVerify)->plainTextToken;
            $this->sendEmailVerify($user->{User::COL_EMAIL}, $tokenVerify, 'http://localhost:3000/forgot-password');
        } else {
            throw new Error(...AuthException::EmailNotExist);
        }
    }

    public function verify($user)
    {
        if ($user->tokenCan($this->abilityVerify[0])) {
            $user->{User::COL_VERIFY} = null;
            $user->{User::COL_STATUS} = 1;
            $user->save();

            $user->currentAccessToken()->delete();
            $accessToken = $user->createToken($this->tokenName, $this->abilities)->plainTextToken;

            return $accessToken;
        }
        return null;
    }

    public function sendEmailVerify($email, $verifyCode, $domain)
    {
        Mail::to($email)->send(new AuthMail($verifyCode, $domain));
    }
}
