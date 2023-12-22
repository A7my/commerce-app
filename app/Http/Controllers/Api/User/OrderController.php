<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Cart;
use App\Models\Admin;
use App\Models\Order;
use App\Helpers\helper;
use Illuminate\Http\Request;
use App\Notifications\MakeOrder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\OrderRequest;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;

class OrderController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new helper();
    }

    public function order(OrderRequest $request)
    {
        // Get the carts these not ordered yet
        $cart = Cart::where('user_id' , Auth::guard('user')->user()->id)->where('is_ordered' , '0')->get();
            // Check if the cart not empty
            if(!empty($cart[0])){

                // Get the total price of the carts
                $total_price = 0;
                foreach($cart as $c){
                    $total_price  = $total_price + $c->total_price;
                }
                // Create an order
                $order = new Order();
                $order->user_id  = Auth::guard('user')->user()->id;
                $order->address = $request->address;
                $order->total_price = $total_price;
                $order->save();

                foreach($cart as $c){
                    $editCart = Cart::find($c->id);
                    $editCart->order_id = $order->id;
                    $editCart->is_ordered = '1';
                    $editCart->save();
                }

                $options = array(
                    'cluster' => 'ap2',
                    'useTLS' => true
                );


                $pusher = new Pusher(
                    env('PUSHER_APP_KEY'),
                    env('PUSHER_APP_SECRET'),
                    env('PUSHER_APP_ID'),
                    $options
                );
                $data = ['A client has made an order, check notifications'];
                $pusher->trigger('ff', 'nn', $data);


                $admin = Admin::find(1);
                Notification::send($admin , new MakeOrder(Auth::guard('user')->user()->name ,$order->id));

                $orderDetail = Order::with('carts.product')->find($order->id);
                return $this->helper->ResponseJson( 1 , 'You have made an order successfully' , [ 'orderDetails' => $orderDetail ]);

            }else{
                return $this->helper->ResponseJson( 0 , 'Your cart is empty' );
            }
    }
    // {
    //     $options = array(
    //         'cluster' => 'ap2',
    //         'useTLS' => true
    //     );


    //     $pusher = new Pusher(
    //         env('PUSHER_APP_KEY'),
    //         env('PUSHER_APP_SECRET'),
    //         env('PUSHER_APP_ID'),
    //         $options
    //     );
    //     $data = ['from' => 3];
    //     $pusher->trigger('azmy1', 'azmy2', $data);
    // }

    public function orderDetails($id){
        $order = Order::where('user_id' , Auth::guard('user')->user()->id)->where('id' , $id)->with('carts')->first();
        return $this->helper->ResponseJson( 1 , 'order' , $order);
    }


    public function orderDelivered($id){
        $order = Order::where('id' ,$id)->where('user_id' , Auth::guard('user')->user()->id)->first();
        if($order){
            $order->status = 'deliverd';
            $order->save();
            return $this->helper->ResponseJson( 1 , 'Delivered Successfully');
        }else{
            return $this->helper->ResponseJson( 0 , 'No data');
        }
    }

    public function orderNotDelivered($id){
        $order = Order::where('id' ,$id)->where('user_id' , Auth::guard('user')->user()->id)->first();
        if($order){
            $order->status = 'not_delivered';
            $order->save();
            return $this->helper->ResponseJson( 1 , 'Not Delivered?, We will contact you within minutes');
        }else{
            return $this->helper->ResponseJson( 0 , 'No data');
        }
    }
}
