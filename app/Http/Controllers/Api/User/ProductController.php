<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public $helper;

    public function __construct(){
        $this->helper = new helper();
    }

    public function products(){
        $products = Product::get();
        return $this->helper->ResponseJson( 1 , 'products' , [ 'products data' => $products ] );
    }

    public function product($id)
    {
        $product = Product::find($id);
        if($product){
            return $this->helper->ResponseJson( 1 , 'product' , $product );
        }else{
            return $this->helper->ResponseJson( 0 , 'there is no such a prdouct');
        }
    }

}
