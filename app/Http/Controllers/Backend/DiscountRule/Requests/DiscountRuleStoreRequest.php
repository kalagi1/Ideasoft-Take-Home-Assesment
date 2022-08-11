<?php 

namespace App\Http\Controllers\Backend\DiscountRule\Requests;

use App\Http\Requests\BaseFormRequest;

class DiscountRuleStoreRequest extends BaseFormRequest{
    public function rules(): array
    {
        return [
            'key' => 'required',
            'discount' => 'required',
            'discount_type' => 'required',
            'number_of_uses' => 'required',
        ];
    }
}