<?php

namespace App\Http\Controllers\Backend\DiscountRule\Controllers;

use App\Http\Controllers\Backend\DiscountRule\Requests\DiscountRuleStoreRequest;
use App\Http\Controllers\Backend\DiscountRule\Requests\DiscountRuleUpdateRequest;
use App\Http\Controllers\Backend\DiscountRule\Services\DiscountRuleService;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponses;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountRuleController extends Controller
{
    private $service;

    public function __construct(DiscountRuleService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return $this->service->index();
    }

    public function store(DiscountRuleStoreRequest $request){
        return $this->service->store($request->all());
    }

    public function show($id){
        return $this->service->show($id);
    }

    public function update($id,DiscountRuleUpdateRequest $request){
        return BaseResponses::update($this->service->update($id,$request->all()));
    }

    public function destroy($id){
        return BaseResponses::delete($this->service->destroy($id));
    }
}
