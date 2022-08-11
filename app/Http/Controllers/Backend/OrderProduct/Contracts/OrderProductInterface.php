<?php 

namespace App\Http\Controllers\Backend\OrderProduct\Contracts;

interface OrderProductInterface{
    public function getOrderProductsByOrderId($orderId, $columns = ["*"]);

    public function createOrderProduct($request);
}