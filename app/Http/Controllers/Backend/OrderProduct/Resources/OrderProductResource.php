<?php 

namespace App\Http\Controllers\Backend\OrderProduct\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderProductResource extends JsonResource{
    public function toArray($request)
    {
        return [
            'productId' => $this->id,
            'quantity' => $this->quantity,
            'unitPrice' => $this->unit_price,
            'total' => $this->total,
        ];
    }
}