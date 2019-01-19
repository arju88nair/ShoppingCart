<?php

namespace App\Http\Controllers;

use App\Carts;
use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use DB;


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

    /**
     * Getting all the products from the Model
     * @return \Illuminate\Http\JsonResponse
     */

    public function getProducts()
    {
        $products = Products::all();
        return response()->json([
            'products' => $products
        ]);

    }

    /**
     * @param Request $request
     * Method for adding the item to the cart and doing subsequent operations
     * @return \Illuminate\Http\JsonResponse
     */

    public function addToCart(Request $request)
    {
        $product_id = $request['id'];

        if (empty($product_id)) {
            return response()->json(['message' => 'Product does not exist ', 'status' => Response::$statusTexts['204'], 'code' => Response::HTTP_NO_CONTENT], Response::HTTP_NO_CONTENT);

        }


        $user = Auth::id();
        $carts = Carts::where('product_id', '=', $product_id)->where('user_id', '=', $user)
            ->first();
        if (empty($carts)) {

        // Adding to the cart if not found
            $cart = new Carts();
            $cart->product_id = $product_id;
            $cart->user_id = $user;
            $cart->count = 1;
            $is_saved = $cart->save();
            if ($is_saved) {
                return response()->json(['message' => 'Successfully saved', 'status' => Response::$statusTexts['200'], 'code' => Response::HTTP_OK], Response::HTTP_OK);
            }
            return response()->json(['message' => 'Something went wrong', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }

        // Incrementing the count if product is found for the user
        $count = (int)$carts['count'];
        $count++;
        $carts->count = $count;
        $is_saved = $carts->save();
        if ($is_saved) {
            return response()->json(['message' => 'Successfully updated', 'status' => Response::$statusTexts['200'], 'code' => Response::HTTP_OK], Response::HTTP_OK);
        }
        return response()->json(['message' => 'error', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);

    }

    /**
     * Getting cart contents
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public static function cart()
    {
        $user = Auth::id();
        $query = "SELECT p.name,c.count,p.price FROM carts c inner join products p on p.id =c.product_id inner join users u on u.id=c.user_id where u.id=" . $user . "";
        $items = DB::select($query);
        $total = DB::select("select SUM(p.price) as price from carts c inner join products p on p.id=c.product_id where c.user_id=" . $user . "");
        return view('checkout', ['items' => $items, 'total' => $total[0]->price]);
    }
}
