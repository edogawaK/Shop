<?php

namespace App\Exceptions\ExceptionList;

class AuthException
{
    const SiginFail = [
        'message' => 'Đăng nhập không thành công',
        'code' => 404,
    ];

    const SignupFail = [
        'message' => 'Đăng ký không thành công',
        'code' => 404,
    ];

    const NotVerify = [
        'message' => 'Người dùng chưa xác thực',
        'code' => 404,
    ];

    const VerifyFail = [
        'message' => 'Xác thực email không thành công',
        'code' => 404,
    ];

    const ForgotFail = [
        'message' => 'Đổi mật khẩu không thành công',
        'code' => 404,
    ];

    const AuthRequire = [
        'message' => 'Vui lòng đăng nhập để tiếp tục',
        'code' => 404,
    ];
}
