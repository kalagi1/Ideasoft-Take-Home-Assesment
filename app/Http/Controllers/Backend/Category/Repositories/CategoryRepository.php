<?php

namespace App\Http\Controllers\Backend\Category\Repositories;

use App\Http\Controllers\Backend\Category\Contracts\CategoryInterface;
use App\Models\Category;

class CategoryRepository implements CategoryInterface{

    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getCategories(){
        return $this->category
            ->get(); 
    }

    public function createCategory($request){
        return $this->category->create([
            "name" => $request->name
        ]);
    }

    public function getCategoryById($id){
        return $this->category
            ->where('id',$id)
            ->firstOrFail();
    }

    public function updateCategory($id,$request){
        $category = $this->getCategoryById($id);
        return $category->update([
            "name" => $request->name
        ]);
    }

    public function deleteCategory($id){
        $category = $this->getCategoryById($id);

        return $category->delete();
    }
}