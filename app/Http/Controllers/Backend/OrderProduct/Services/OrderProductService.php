<?php 

namespace App\Http\Controllers\Backend\OrderProduct\Services;

use App\Http\Controllers\Backend\OrderProduct\Contracts\OrderProductInterface;

class OrderProductService{

    private $repository;

    public function __construct(OrderProductInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index($orderId){
        return $this->repository->getOrderProductsByOrderId($orderId);
    }
}