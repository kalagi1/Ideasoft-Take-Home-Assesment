<?php

namespace App\Http\Controllers\Backend\OrderProduct\Controllers;

use App\Http\Controllers\Backend\OrderProduct\Services\OrderProductService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderProductController extends Controller
{
    private $service;

    public function __construct(OrderProductService $service)
    {
        $this->service = $service;
    }
    
    public function index($orderId){
        return $this->service->index($orderId);
    }
}
