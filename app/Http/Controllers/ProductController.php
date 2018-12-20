<?php

namespace App\Http\Controllers;

use App\Carts;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\PreDec;
use Symfony\Component\HttpFoundation\Response;


class ProductController extends Controller
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


    public function productDetail(Request $request)
    {
        $product_id = $request['id'];
        $product=Products::find($product_id);
        $user = Auth::id();
        $is_added = Carts::where('product_id', '=', $product_id)->where('user_id', '=', $user)
            ->first();
        return view('product',['product'=>$product,'is_added'=>count($is_added)]);

    }


}
