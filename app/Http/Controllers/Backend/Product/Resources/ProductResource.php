<?php 

namespace App\Http\Controllers\Backend\Product\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category_id,
            'price' => $this->price,
            'stock' => $this->stock,
        ];
    }
}