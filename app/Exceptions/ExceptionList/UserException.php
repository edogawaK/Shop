<?php

namespace App\Exceptions\ExceptionList;

class UserException
{
    const NotFound = [
        'message' => 'Không tìm thấy người dùng',
        'code' => 404,
    ];

    const NotActive = [
        'message' => 'Tài khoản người dùng đã bị khóa',
        'code' => 404,
    ];

    const EmailExisted = [
        'message' => 'Email đã được đăng ký',
        'code' => 404,
    ];
}
