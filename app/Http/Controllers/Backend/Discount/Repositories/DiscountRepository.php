<?php 

namespace App\Http\Controllers\Backend\Discount\Repositories;

use App\Http\Controllers\Backend\Discount\Contracts\DiscountInterface;
use App\Models\Discount;

class DiscountRepository implements DiscountInterface{

    private $discount;

    public function __construct(Discount $discount)
    {
        $this->discount = $discount;
    }

    public function createDiscount($request){
        return $this->discount->create($request);
    }

    public function getDiscountByOrderId($id){
        return $this->discount->where('order_id',$id)->get();
    }
}