<?php

namespace App\Http\Controllers\Backend\Discount\Controllers;

use App\Http\Controllers\Backend\Discount\Services\DiscountService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    private $service;
    
    public function __construct(DiscountService $service)
    {
        $this->service = $service;
    }

    public function calculateDiscount(Request $request){
        return $this->service->calculateDiscount($request);
    }

    public function getOrderDiscounts($orderId){
        return $this->service->getOrderDiscounts($orderId);
    }
}
