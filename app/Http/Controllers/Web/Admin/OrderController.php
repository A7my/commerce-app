<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('carts')->orderBy('created_at', 'desc')->get();
        return view('admin.orders.index' , compact('orders'));
    }
}
