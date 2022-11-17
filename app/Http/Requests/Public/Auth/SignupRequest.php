<?php

namespace App\Http\Requests\Public\Auth;

use App\Http\Requests\Public\Auth\AuthConvert;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SignupRequest extends FormRequest
{
    use AuthConvert;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (Auth::check()) {
            return false;
        }
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
            'email' => 'bail|required|regex:/(.+)@(.+)\.(.+)/i',
            'name' => 'bail|required|string',
            'password' => 'bail|required|min:6',
            'city' => 'bail|required|integer',
            'district' => 'bail|required|integer',
            'ward' => 'bail|required|integer',
            'phone' => 'bail|required',
            'street' => 'bail|required|string',
        ];
    }
}
