<?php

namespace App\Http\Controllers\Backend\Discount\Services;

use App\Http\Controllers\Backend\Discount\Contracts\DiscountInterface;
use App\Http\Controllers\Backend\DiscountRule\Contracts\DiscountRuleInterface;
use App\Http\Controllers\Backend\Order\Contracts\OrderInterface;
use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;

class DiscountService{
    private $repository;

    public function __construct(DiscountInterface $repository)
    {
        $this->repository = $repository;
    }

    public function calculateDiscount($request){
        $prod = [];
        $prodWithQuantity = array();
        $productCategories = array();
        for($i = 0 ; $i < count($request->products); $i++){
            $product = app()->make(ProductInterface::class)->getProductById($request->products[$i]['id']);
            array_push($prod,$request->products[$i]['id']);
            $prodWithQuantity[$request->products[$i]['id']] = (isset($prodWithQuantity[$request->products[$i]['id']]) ? $prodWithQuantity[$request->products[$i]['id']] : 0) + $request->products[$i]['quantity'];
            $productCategories[$request->products[$i]['id']] = $product->category_id;
        }
        $totalPrice = app()->make(ProductInterface::class)->getTotalPrice($prod,$prodWithQuantity);
        $lastPrice = $totalPrice;
        $discounts = app()->make(DiscountRuleInterface::class)->getDiscountRulesNumberOfUsesIsGreaterThanZero();
        $discountsarr = array();
        foreach($discounts as $discount){
            if($discount->discount_item_type != null){
                if($discount->category_id != null && $discount->product_id == null){
                    if(!$discount->is_equal_products_on_category){
                        $totalCount = 0;
                        $products = app()->make(ProductInterface::class)->getProductsByIdArrayAndCategoryId($prod,$discount->category_id);
                        foreach($products as $product){
                            $totalCount = $totalCount + $prodWithQuantity[$product->id];
                        }
                        if($discount->min_item <= $totalCount){
                            if($discount->discount_item_type == 1){
                                $calcProduct = app()->make(ProductInterface::class)->getProductByDBRawAndIdArrayAndCategoryId($prod,$discount->category_id,'min(price) as price');
                            }else{
                                $calcProduct = app()->make(ProductInterface::class)->getProductByDBRawAndIdArrayAndCategoryId($prod,$discount->category_id,'max(price) as price');
                            }
                            if($discount->discount_type == 1){
                                $discountAmount = (($calcProduct->price * ($discount->discount / 100)) * $discount->discount_item_count);
                                $lastPrice =  $lastPrice - (($calcProduct->price * ($discount->discount / 100)) * $discount->discount_item_count);
                            }else{
                                $lastPrice = $lastPrice - $discount->discount;
                                $discountAmount = $discount->discount;
                            }

                            array_push($discountsarr,[
                                "discountReason" => $discount->key,
                                "subtotal" => $lastPrice,
                                "discountAmount" => $discountAmount
                            ]); 
                        }
                    }else{
                        $totalCount = 0;
                        $products = app()->make(ProductInterface::class)->getProductsByIdArrayAndCategoryId($prod,$discount->category_id);
                        foreach($products as $product){
                            $totalCount = $prodWithQuantity[$product->id];

                            if($discount->min_item <= $totalCount){
                                if($discount->discount_type == 1){
                                    $discountAmount = (($product->price * ($discount->discount / 100)) * $discount->discount_item_count);
                                    $lastPrice =  $lastPrice - (($product->price * ($discount->discount / 100)) * $discount->discount_item_count);
                                }else{
                                    $lastPrice = $lastPrice - $discount->discount;
                                    $discountAmount = $discount->discount;
                                }
                                array_push($discountsarr,[
                                    "discountReason" => $discount->key,
                                    "subtotal" => $lastPrice,
                                    "discountAmount" => $discountAmount
                                ]); 
                            }
                        }
                    }
                }else if($discount->product_id != null){
                    $product = app()->make(ProductInterface::class)->getProductById($discount->product_id);
                    $totalProduct = $prodWithQuantity[$discount->product_id] * $product->price;
                    if($discount->min_item < $prodWithQuantity[$discount->product_id] && $totalProduct > $discount->min_price){
                        if($discount->discount_type == 1){
                            $discountAmount = (($product->price * ($discount->discount / 100)) * $discount->discount_item_count);
                            $lastPrice =  $lastPrice - (($product->price * ($discount->discount / 100)) * $discount->discount_item_count);
                        }else{
                            $lastPrice = $lastPrice - $discount->discount;
                            $discountAmount = $discount->discount;
                        }
                        array_push($discountsarr,[
                            "discountReason" => $discount->key,
                            "subtotal" => $lastPrice,
                            "discountAmount" => $discountAmount
                        ]); 
                    }
                }
            }else{
                if($discount->category_id  == null && $discount->product_id == null){
                    if($discount->discount_type == 1){
                        $discountAmount = ($totalPrice * ($discount->discount / 100));
                        $lastPrice =  ($lastPrice) - ($totalPrice * ($discount->discount / 100));
                    }else{
                        $lastPrice = $lastPrice - $discount->discount;
                        $discountAmount = $discount->discount;
                    }
                    array_push($discountsarr,[
                        "discountReason" => $discount->key,
                        "subtotal" => $lastPrice,
                        "discountAmount" => $discountAmount
                    ]); 
                }else if($discount->category_id != null && $discount->product_id == null){
                    if($discount->is_equal_products_on_category){
                        $products = app()->make(ProductInterface::class)->getProductsByIdArrayAndCategoryId($prod,$discount->category_id);
                        $totalProduct = 0;
                        foreach($products as $product){
                            $totalProduct = $totalProduct + ($product->price * $prodWithQuantity[$product->id]);
                            if($discount->min_item <= $prodWithQuantity[$product->id] && $totalProduct > $discount->min_price){
                                if($discount->discount_type == 1){
                                    $discountAmount = ($totalProduct * ($discount->discount / 100));
                                    $lastPrice = $lastPrice - ($totalProduct * ($discount->discount / 100));
                                }else{
                                    $lastPrice = $lastPrice - $discount->discount;
                                    $discountAmount = $discount->discount;
                                }
                                array_push($discountsarr,[
                                    "discountReason" => $discount->key,
                                    "subtotal" => $lastPrice,
                                    "discountAmount" => $discountAmount
                                ]); 
                            }
                        }
                    }else{
                        $totalCount = 0;
                        $products = app()->make(ProductInterface::class)->getProductsByIdArrayAndCategoryId($prod,$discount->category_id);
                        foreach($products as $product){
                            $totalCount = $totalCount + $prodWithQuantity[$product->id];
                        }
                        $totalProduct = 0;
                        foreach($products as $product){
                            $totalProduct = $totalProduct + ($product->price * $prodWithQuantity[$product->id]);
                        }
                        
                        if($discount->min_item < $totalCount && $totalProduct > $discount->min_price){
                            if($discount->discount_type == 1){
                                $discountAmount = ($totalProduct * ($discount->discount / 100));
                                $lastPrice = $lastPrice - ($totalProduct * ($discount->discount / 100));
                            }else{
                                $lastPrice = $lastPrice - $discount->discount;
                                $discountAmount = $discount->discount;
                            }
                            array_push($discountsarr,[
                                "discountReason" => $discount->key,
                                "subtotal" => $lastPrice,
                                "discountAmount" =>  $discountAmount 
                            ]); 
                        }
                    }
                }else{
                    $product = app()->make(ProductInterface::class)->getProductById($discount->product_id);
                    $totalProduct = $prodWithQuantity[$discount->product_id] * $product->price;
                    if($discount->min_item < $prodWithQuantity[$discount->product_id] && $totalProduct > $discount->min_price){
                        if($discount->discount_type == 1){
                            $discountAmount = ($totalProduct * ($discount->discount / 100));
                            $lastPrice = $lastPrice - ($totalProduct * ($discount->discount / 100));
                        }else{
                            $lastPrice = $lastPrice - $discount->discount;
                            $discountAmount = $discount->discount;
                        }
                        array_push($discountsarr,[
                            "discountReason" => $discount->key,
                            "subtotal" => $lastPrice,
                            "discountAmount" => $discountAmount
                        ]); 
                    }
                }
            }
        }

        return $discountsarr;
    }

    public function getOrderDiscounts($orderId){
        $order = app()->make(OrderInterface::class)->getOrderById($orderId);
        $lastPrice = $order->total;
        $discounts = $this->repository->getDiscountByOrderId($orderId);
        $res = [];
        foreach($discounts as $discount){
            $lastPrice = $lastPrice - $discount->discount_amount;
            $discountRule = app()->make(DiscountRuleInterface::class)->getDiscountRuleById($discount->discount_rule_id);
            $data = [
                "discountReason" => $discountRule->key,
                "subtotal" => $lastPrice,
                "discountAmount" => $discount->discount_amount,
            ];
            array_push($res,$data);
        }

        return $res;
    }
}