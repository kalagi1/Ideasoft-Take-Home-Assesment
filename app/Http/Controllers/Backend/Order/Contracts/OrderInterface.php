<?php

namespace App\Http\Controllers\Backend\Order\Contracts;

interface OrderInterface{
    public function getOrders();

    public function createOrder($request);

    public function getOrderById($id);
}