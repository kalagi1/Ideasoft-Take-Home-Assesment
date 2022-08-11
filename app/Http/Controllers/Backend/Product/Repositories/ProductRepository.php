<?php 

namespace App\Http\Controllers\Backend\Product\Repositories;

use App\Http\Controllers\Backend\Category\Contracts\CategoryInterface;
use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductInterface{

    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProducts(){
        return $this->product
        ->get();
    }

    public function createProduct($request){
        app()->make(CategoryInterface::class)->getCategoryById($request->category_id);
        return $this->product->create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
    }

    public function getProductById($id){
        return $this->product
        ->where('id',$id)
        ->firstOrFail();
    }

    public function updateProduct($id,$request){
        $product = $this->getProductById($id);
        $category = app()->make(CategoryInterface::class)->getCategoryById($request->category_id);
        return $product->update([
            'name' => $request->name,
            'category_id' => $category->id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
    }
    
    public function deleteProduct($id){
        $product = $this->getProductById($id);

        return $product->delete();
    }

    public function changeProductStockCountById($id,$quantity,$increase = true){
        $product = $this->getProductById($id);
        if($increase){
            $product->update([
                "stock" => $product->stock - $quantity
            ]);
        }else{
            $product->update([
                "stock" => $product->stock + $quantity
            ]);
        }
    }

    public function productStockControlWithDifference($id,$quantity){
        $product = $this->getProductById($id);
        if($product->stock < $quantity){
            return false;
        }else{
            return true;
        }
    }

    public function getTotalPrice($products,$quantity){
        $products = $this->product->whereIn('id',$products)->get();
        $totalPrice = 0;
        foreach($products as $product){
            $totalPrice += $product->price * $quantity[$product->id];
        }

        return $totalPrice;
    }

    public function getProductsByIdArrayAndCategoryId(array $productIds , int $categoryId , $columns = ['*']){
        return $this->product->select($columns)->whereIn('products.id',$productIds)->where('category_id',$categoryId)->get();
    }

    public function getProductByDBRawAndIdArrayAndCategoryId(array $productIds , int $categoryId , string $select){
        return $this->product->select(DB::raw($select))->whereIn('products.id',$productIds)->where('category_id',$categoryId)->firstOrFail();
    }
}