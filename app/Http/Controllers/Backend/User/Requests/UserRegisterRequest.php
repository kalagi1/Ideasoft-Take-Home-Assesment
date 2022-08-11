<?php 

namespace App\Http\Controllers\Backend\User\Requests;

use App\Http\Requests\BaseFormRequest;

class UserRegisterRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}