<?php 

namespace App\Http\Controllers\Backend\Order\Repositories;

use App\Http\Controllers\Backend\Order\Contracts\OrderInterface;
use App\Models\Order;

class OrderRepository implements OrderInterface{
    private $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function getOrders(){
        $orders = $this->order
            ->where('customer_id',auth()->user()->id)
            ->get();

        foreach($orders as $order){
            $order->products;
        }

        return $orders;
    }

    public function createOrder($request){
        return $this->order->create([
            "customer_id" => auth()->user()->id,
            "total" => $request['total']
        ]);
    }

    public function getOrderById($id){
        $order = $this->order
            ->where('customer_id',auth()->user()->id)
            ->where('id',$id)
            ->firstOrFail();

        $order->products->makeHidden(['id','order_id','created_at','updated_at']);

        return $order->makeHidden([
            'created_at','updated_at']);
    }
}