<?php 

namespace App\Http\Controllers\Backend\Order\Resources;

use App\Http\Controllers\Backend\OrderProduct\Resources\OrderProductResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customerId' => $this->customer_id,
            'items' => OrderProductResource::collection($this->products),
            'total' => $this->total,
        ];
    }
}