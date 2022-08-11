<?php 

namespace App\Http\Controllers\Backend\Product\Contracts;

interface ProductInterface{
    public function getProducts();

    public function createProduct($request);

    public function getProductById($id);

    public function updateProduct($id,$request);

    public function deleteProduct($id);

    public function getTotalPrice($products,$quantity);
}