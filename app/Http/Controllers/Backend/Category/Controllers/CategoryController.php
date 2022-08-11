<?php

namespace App\Http\Controllers\Backend\Category\Controllers;

use App\Http\Controllers\Backend\Category\Requests\CategoryStoreRequest;
use App\Http\Controllers\Backend\Category\Requests\CategoryUpdateRequest;
use App\Http\Controllers\Backend\Category\Resources\CategoryResource;
use App\Http\Controllers\Backend\Category\Services\CategoryService;
use App\Http\Controllers\Controller;
use App\Http\Responses\BaseResponses;

class CategoryController extends Controller
{
    private $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(){
        return CategoryResource::collection($this->service->index());
    }

    public function store(CategoryStoreRequest $request){
        return new CategoryResource($this->service->store($request));
    }

    public function show($id){
        return new CategoryResource($this->service->show($id));
    }

    public function update($id,CategoryUpdateRequest $request){
        return BaseResponses::update($this->service->update($id,$request));
    }

    public function destroy($id){
        return BaseResponses::delete($this->service->destroy($id));
    }
}
