<?php 

namespace App\Http\Controllers\Backend\Order\Requests;

use App\Http\Requests\BaseFormRequest;

class OrderStoreRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'products' => 'required',
        ];
    }
}