<?php 

namespace App\Http\Controllers\Backend\Category\Contracts;

interface CategoryInterface{

    public function getCategories();

    public function createCategory($request);

    public function getCategoryById($id);

    public function updateCategory($id,$request);

    public function deleteCategory($id);
}