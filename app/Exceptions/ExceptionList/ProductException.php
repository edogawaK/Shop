<?php

namespace App\Exceptions\ExceptionList;

class UserException
{
    const NotFound = [
        'message' => 'Không tìm thấy sản phẩm',
        'code' => 404,
    ];

    const QuantityNotEnough = [
        'message' => 'Sản phẩm không có đủ số lượng',
        'code' => '404',
    ];
}
