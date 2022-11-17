<?php

namespace App\Http\Requests\Private\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    use ProductConvert;
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
            'name' => 'bail|required',
            'price' => 'bail|required|numeric|min:0',
            'cost' => 'bail|numeric|min:0',
            'categoryId' => 'bail|required',
            'sizes' => 'required|array',
            'sizes.*.id' => 'bail|required',
            'sizes.*.quantity' => 'bail|required',
            'images'=>'bail'
        ];
    }
}
