<?php

namespace App\Http\Controllers\Backend\Product\Requests;

use App\Http\Requests\BaseFormRequest;

class ProductUpdateRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ];
    }
}