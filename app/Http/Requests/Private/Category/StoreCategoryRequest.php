<?php

namespace App\Http\Requests\Private\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreCategoryRequest extends FormRequest
{
    use CategoryConvert;
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
            'parent' => 'bail|int|string',
        ];
    }

    public function messages()
    {
        return [
            'name' => 'Tên Category không hợp lệ',
            'parent' => 'Category parent không hợp lệ',
        ];
    }
}
