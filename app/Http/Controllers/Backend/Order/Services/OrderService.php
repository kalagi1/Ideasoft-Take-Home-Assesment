<?php 

namespace App\Http\Controllers\Backend\Order\Services;

use App\Http\Controllers\Backend\Discount\Contracts\DiscountInterface;
use App\Http\Controllers\Backend\Discount\Controllers\DiscountController;
use App\Http\Controllers\Backend\DiscountRule\Contracts\DiscountRuleInterface;
use App\Http\Controllers\Backend\Order\Contracts\OrderInterface;
use App\Http\Controllers\Backend\OrderProduct\Contracts\OrderProductInterface;
use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;
use Illuminate\Support\Facades\DB;

class OrderService{

    private $repository;

    public function __construct(OrderInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index(){
        return $this->repository->getOrders();
    }

    public function store($request){
        return DB::transaction(function () use($request) {
            DB::beginTransaction();
            $prod = [];
            $prodWithQuantity = array();
            $productCategories = array();
            for($i = 0 ; $i < count($request->products); $i++){
                $product = app()->make(ProductInterface::class)->getProductById($request->products[$i]['id']);
                array_push($prod,$request->products[$i]['id']);
                $prodWithQuantity[$request->products[$i]['id']] = (isset($prodWithQuantity[$request->products[$i]['id']]) ? $prodWithQuantity[$request->products[$i]['id']] : 0) + $request->products[$i]['quantity'];
                $productCategories[$request->products[$i]['id']] = $product->category_id;
            }
            $orderData = $request->all();
            $orderData['total'] = app()->make(ProductInterface::class)->getTotalPrice($prod,$prodWithQuantity);
            $order = $this->repository->createOrder($orderData);
            foreach($request->products as $product){
                $productData = app()->make(ProductInterface::class)->getProductById($product['id']);
                $createOrderProduct = app()->make(OrderProductInterface::class)->createOrderProduct([
                    "order_id" => $order->id,
                    "product_id" => $productData->id,
                    "quantity" => $product['quantity'],
                    "unit_price" => $productData->price,
                    "total" => $productData->price * $product['quantity']
                ]);

                if(isset($createOrderProduct['success']) && $createOrderProduct['success'] == false){
                    return $createOrderProduct;
                    DB::rollback();
                }
            }

            $discounts = app()->make(DiscountController::class)->calculateDiscount($request);
            foreach($discounts as $discount){
                $discountRule = app()->make(DiscountRuleInterface::class)->getDiscountRuleByKey($discount['discountReason']); 
                if(app()->make(DiscountRuleInterface::class)->increaseDıscountRuleNumberOfUses($discountRule->id)){
                    $discountData = [
                        "order_id" => $order->id,
                        "discount_rule_id" => $discountRule->id,
                        "discount_amount" => $discount['discountAmount']
                    ];
                    app()->make(DiscountInterface::class)->createDiscount($discountData);
                }
            }
            DB::commit();
            return $this->repository->getOrderById($order->id);
        });
    }

    public function show($id){
        return $this->repository->getOrderById($id);
    }
}