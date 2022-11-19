<?php

namespace App\Exceptions;

use Exception;
use stdClass;

/* -------------------------------------------------------------------------- */
/*                               Auth Exception                               */
/* -------------------------------------------------------------------------- */

const SigninFail_Exception = [
    'message' => 'Đăng nhập không thành công',
    'code' => '404',
];

const AuthException=new stdClass();
AuthException->

/* -------------------------------------------------------------------------- */
/*                               User Exceptions                              */
/* -------------------------------------------------------------------------- */

const UserNotFound_Exception = [
    'message' => 'Không tìm thấy thông tin người dùng',
    'code' => '404',
];

const UserNotActive_Exception = [
    'message' => 'Tài khoản người dùng đã bị khóa',
    'code' => '404',
];


/* -------------------------------------------------------------------------- */
/*                               Cart Exceptions                              */
/* -------------------------------------------------------------------------- */

const ProductQuantityNotEnough_Exception = [
    'message' => 'Sản phẩm không có đủ số lượng',
    'code' => '404',
];

const CanNotUpdateCart_Exception = [
    'message' => 'Không tìm thấy thông tin người dùng',
    'code' => '404',
];


/* -------------------------------------------------------------------------- */
/*                               OrderException                               */
/* -------------------------------------------------------------------------- */

