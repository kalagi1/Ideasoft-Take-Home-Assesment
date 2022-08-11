<?php 

namespace App\Http\Controllers\Backend\User\Requests;

use App\Http\Requests\BaseFormRequest;

class UserLoginRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}