<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $hidden = [
        'is_ordered',
        'order_id',
        'product_id',
        'user_id',
    ];
    public function user(){
        return $this->belongsTo( User::class ,'user_id' );
    }

    public function product(){
        return $this->belongsTo( Product::class , 'product_id' );
    }

    public function order(){
        return $this->belongsTo(Order::class , 'order_id');
    }
}
