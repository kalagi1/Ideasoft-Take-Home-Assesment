<?php 

namespace App\Http\Controllers\Backend\OrderProduct\Repositories;

use App\Http\Controllers\Backend\OrderProduct\Contracts\OrderProductInterface;
use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;
use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;

class OrderProductRepository implements OrderProductInterface{

    private $orderProduct;

    public function __construct(OrderProduct $orderProduct)
    {
        $this->orderProduct = $orderProduct;
    }

    public function getOrderProductsByOrderId($orderId, $columns = ["*"]){
        return $this->orderProduct
            ->select($columns)
            ->where('order_id',$orderId)
            ->get();
    }

    public function createOrderProduct($request){
        $product = app()->make(ProductInterface::class)->getProductById($request['product_id']);
        $stockControl = app()->make(ProductInterface::class)->productStockControlWithDifference($product->id,$request['quantity']);
        if(!$stockControl){
            return [
                "success" => false,
                "message" => [
                    "products.stock" => $product->name.' ürünü stokta mevcut değil'
                ]
            ];
        }else{
            $stockControl = app()->make(ProductInterface::class)->changeProductStockCountById($product->id,$request['quantity']);
            return $this->orderProduct->create($request);
        }
    }
}