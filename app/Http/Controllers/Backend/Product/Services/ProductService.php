<?php

namespace App\Http\Controllers\Backend\Product\Services;

use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class ProductService{
    private $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        return $this->productRepository->getProducts();
    }

    public function store($request){
        return DB::transaction(function () use($request) {
            return $this->productRepository->createProduct($request);
        });
    }

    public function show($id){
        return $this->productRepository->getProductById($id);
    }

    public function update($id,$request){
        return DB::transaction(function () use($id,$request) {
            return $this->productRepository->updateProduct($id,$request);
        });
    }

    
    public function destroy($id){
        return DB::transaction(function () use($id) {
            return $this->productRepository->deleteProduct($id);
        });
    }
}