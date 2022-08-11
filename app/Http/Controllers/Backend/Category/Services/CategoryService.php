<?php

namespace App\Http\Controllers\Backend\Category\Services;

use App\Http\Controllers\Backend\Category\Contracts\CategoryInterface;
use Illuminate\Support\Facades\DB;

class CategoryService{

    private $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(){
        return $this->categoryRepository->getCategories();
    }

    public function store($request){
        return DB::transaction(function () use($request){
            return $this->categoryRepository->createCategory($request);
        });
    }

    public function show($id){
        return $this->categoryRepository->getCategoryById($id);
    }

    public function update($id,$request){
        return DB::transaction(function () use($id,$request){
            return $this->categoryRepository->updateCategory($id,$request);
        });
    }


    public function destroy($id){
        return $this->categoryRepository->deleteCategory($id);
    }
}