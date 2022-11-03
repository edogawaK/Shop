<?php

namespace App\Http\Errors;

class CartError
{
    const ADD = [
        'message' => 'Không thể thêm sản phẩm vào giỏ',
        'code' => 404,
    ];

    const UPDATE = [
        'message' => 'Không thể cập nhật số lượng sản phẩm ',
        'code' => 404,
    ];

    const ADD_QUANTITY = [
        'message' => 'Không thể thêm sản phẩm vào giỏ do số lượng sản phẩm không đủ!',
        'code' => 404,
    ];

    const UPDATE_QUANTITY = [
        'message' => 'Không thể cập nhật số lượng sản phẩm do số lượng sản phẩm không đủ đáp ứng',
        'code' => 404,
    ];
}
