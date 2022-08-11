<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total','customer_id'];

    public function products(){
        return $this->hasMany(OrderProduct::class,'order_id','id');
    }
}

