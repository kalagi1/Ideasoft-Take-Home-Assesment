<?php 

namespace App\Http\Controllers\Backend\Discount\Contracts;

interface DiscountInterface{
    public function createDiscount($request);
    
    public function getDiscountByOrderId($id);
}