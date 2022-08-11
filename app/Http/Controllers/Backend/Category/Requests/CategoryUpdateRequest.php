<?php 

namespace App\Http\Controllers\Backend\Category\Requests;

use App\Http\Requests\BaseFormRequest;

class CategoryUpdateRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}