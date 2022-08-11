<?php

namespace App\Http\Controllers\Backend\Order\Controllers;

use App\Http\Controllers\Backend\Order\Requests\OrderStoreRequest;
use App\Http\Controllers\Backend\Order\Resources\OrderResource;
use App\Http\Controllers\Backend\Order\Services\OrderService;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    private $service;

    public function __construct(OrderService $service)
    {
        $this->service = $service;
    }

    public function index(){
       return OrderResource::collection($this->service->index());
    }

    public function store(OrderStoreRequest $request){
        if($request->success){
            return new OrderResource($this->service->store($request));
        }else{
            return $this->service->store($request);
        }
    }

    public function show($id){
        return new OrderResource($this->service->show($id));
    }
}
