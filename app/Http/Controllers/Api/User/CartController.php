<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Cart;
use App\Helpers\helper;
use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\CartRequest;

class CartController extends Controller
{
    public $helper;
    public function __construct()
    {
        $this->helper = new helper();
    }

    public function cart(){

        $cart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();

        // Total Price
        $total_price = 0 ;
        foreach($cart as $c){
            $total_price = $total_price + $c->total_price;
        }

        return $this->helper->ResponseJson(1 , 'cart' , ['cart' => $cart , 'total' => $total_price ]);

    }

    public function addToCart(CartRequest $request){

        // Check if the product exist or not
        $product = Product::find($request->product_id);
        
        if($product){
            $existedCart = Cart::where('product_id' , $request->product_id)->where('user_id' , Auth::guard('user')->user()->id)->where('is_ordered' , 0)->get();
            if(isset($existedCart[0])){
                return $this->helper->ResponseJson(0 , 'This Product already existed in your cart');
            }else{
                // If the product existed check the quantity that user needs, as it may to be bigger than the existed quantity
                if($product->qty < $request->quantity){
                    return $this->helper->ResponseJson( 0 , 'Sorry, this quantity is not available for now. there are just ' . $product->qty. ' items!' );
                }else{

                    // Create a cart after all these checks
                    $cart = new Cart();
                    $cart->user_id = Auth::guard('user')->user()->id;
                    $cart->product_id = $request->product_id;
                    $cart->quantity = $request->quantity;
                    $cart->total_price = $request->quantity * $product->price;
                    $cart->save();

                    // Decrease the quantity of the product
                    $product->qty = $product->qty - $request->quantity;
                    $product->save();

                    $allCart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();
                    $total_price = 0 ;
                    foreach($allCart as $c){
                        $total_price = $total_price + $c->total_price;
                    }
                    return $this->helper->ResponseJson( 1 , 'You added a new product to your cart successfully' , ['cart'=>$allCart , 'total'=>$total_price ]);
                }
            }
        }else{
            return $this->helper->ResponseJson( 0 , 'There is no such a product recorded');
        }

    }

    public function removeFromCart($id){

        $cart = Cart::where('is_ordered' , "0")->where('product_id' , $id)->where('user_id' , Auth::guard('user')->user()->id)->with('product')->first();
        // Check if the cart existed or not
        if($cart){

        // if existed get the product quantity back to it
            $product = Product::find($id);
            $product->qty = $product->qty + $cart->quantity;
            $product->save();

            // Destroy the Cart and get the Updated Cart as $cart has the deleted cart so call the cart again
            Cart::destroy($cart->id);
            $updatedCart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();
            $total_price = 0 ;
            foreach($updatedCart as $c){
                $total_price = $total_price + $c->total_price;
            }
            return $this->helper->ResponseJson( 1 , 'You have deleted the product successfully' , ['cart'=>$updatedCart , 'total'=>$total_price]);
        }else{
            $allCart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();
            $total_price = 0 ;
            foreach($allCart as $c){
                $total_price = $total_price + $c->total_price;
            }
            return $this->helper->ResponseJson( 0 , 'Your cart not having this product' , ['cart' => $allCart, 'total' => $total_price ]);
        }


    }

    public function clearCart(){
        $cart = Cart::where('user_id' , Auth::guard('user')->user()->id)->where('is_ordered' , "0")->get();
        foreach($cart as $c){
            $product = Product::find($c->product_id);
            $product->qty = $product->qty + $c->quantity;
            $product->save();
            Cart::destroy($c->id);
        }
        return $this->helper->ResponseJson(1 , 'you have cleared your cart succesfully');
    }

    public function increaseCart($id){
        // Check if the product exists
        $product = Product::find($id);
        if($product){

            $existedCart = Cart::where('product_id' , $id)->where('user_id' , Auth::guard('user')->user()->id)->where('is_ordered' , "0")->first();
            if($existedCart){
                // Check if the product quantity more than zero as if it , not available to increase your cart
                if( $product->qty != 0 ){
                        // increase the quantity of the cart
                        $existedCart->quantity = $existedCart->quantity + 1;
                        $existedCart->save();
                        // AND update the total price of the cart
                        $existedCart->total_price = $existedCart->quantity * $product->price;
                        $existedCart->save();
                        // AND decrease the quantity of the product
                        $product->qty = $product->qty - 1 ;
                        $product->save();

                        $allCart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();
                        $total_price = 0 ;
                        foreach($allCart as $c){
                            $total_price = $total_price + $c->total_price;
                        }
                        return $this->helper->ResponseJson(1 , 'You have increased the quantity of the product' , ['cart' => $allCart , 'total' => $total_price ]);
                }else{
                    return $this->helper->ResponseJson(0 , 'sorry, there is no more!' );
                }
            }else{
                return $this->helper->ResponseJson(0 , ' This product not existed in your cart!');
            }
        }else{
            return $this->helper->ResponseJson(0 , 'This product not existed!');

        }
    }

    public function decreaseCart($id){
        $product = Product::find($id);
        if($product){
            $existedCart = Cart::where('product_id' , $id)->where('user_id' , Auth::guard('user')->user()->id)->where('is_ordered' , "0")->first();
            if($existedCart){

                    // After decreasing the quantity
                    $existedCart->quantity = $existedCart->quantity - 1;
                    $existedCart->save();
                    // We have to update the quantity
                    $existedCart->total_price = $existedCart->quantity * $product->price;
                    $existedCart->save();
                    // and increase the quantity of the product in our store
                    $product->qty = $product->qty + 1 ;
                    $product->save();


                    $allCart = Cart::where('is_ordered' , "0")->where('user_id' , Auth::guard('user')->user()->id)->with('product')->get();
                    $total_price = 0 ;
                    foreach($allCart as $c){
                        $total_price = $total_price + $c->total_price;
                    }

                    // HERE if the quantity reached the ZERO, delete the product from the cart
                    if($existedCart->quantity == 0 ){
                        $existedCart->delete();
                        return $this->helper->ResponseJson(1 , 'The product no longer in your cart' , ['cart' => $allCart , 'total' => $total_price]);
                    }

                    return $this->helper->ResponseJson(1 , 'You decreased the quantity of the product' , ['cart' => $allCart , 'total' => $total_price]);

            }else{
                return $this->helper->ResponseJson(0 , 'Your cart not include this product');
            }
        }else{
            return $this->helper->ResponseJson(0 , 'Unavailable Product');
        }
    }
}
