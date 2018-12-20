<?php

namespace App\Http\Controllers;

use App\Carts;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getProducts()
    {
        $products = Products::all();
        return response()->json([
            'products' => $products
        ]);

    }


    public function addToCart(Request $request)
    {
        $product_id=$request['product_id'];
        $user=Auth::id();
        $carts=Carts::where('product_id','=', $product_id)->where('user_id','=',$user)
            ->get();
        if(empty($carts))
        {
            $cart=new Carts();
            $cart->product_id=$product_id;
            $cart->user_id=user_id;
            $cart->count=1;
            $is_saved=$cart->save();
            if($is_saved)
            {
            }
        }
        return $carts;

        Carts::updateOrCreate(
            ['product_id' => $product_id, 'user_id' => $user],
            ['count' => 99]
        );



    }
}
