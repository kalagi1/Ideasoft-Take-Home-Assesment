<?php

namespace App\Http\Controllers\Backend\Product\Controllers;

use App\Http\Controllers\Backend\Product\Requests\ProductStoreRequest;
use App\Http\Controllers\Backend\Product\Requests\ProductUpdateRequest;
use App\Http\Controllers\Backend\Product\Resources\ProductResource;
use App\Http\Controllers\Backend\Product\Services\ProductService;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponses;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(){
        return ProductResource::collection($this->productService->index());
    }

    public function store(ProductStoreRequest $productStoreRequest){
        return new ProductResource($this->productService->store($productStoreRequest));
    }

    public function show($id){
        return new ProductResource($this->productService->show($id));
    }

    public function update($id , ProductUpdateRequest $request){
        return BaseResponses::update($this->productService->update($id,$request));
    }

    public function destroy($id){
        return BaseResponses::delete($this->productService->destroy($id));
    }
}
