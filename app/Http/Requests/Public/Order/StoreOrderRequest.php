<?php

namespace App\Http\Requests\Public\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    use OrderConvert;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'locateId'=>'bail|required',
            'detail.*.productId' => 'bail|required',
            'detail.*.sizeId' => 'bail|required',
            'detail.*.quantity' => 'bail|numeric|min:1',
        ];
    }
}
