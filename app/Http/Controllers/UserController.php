<?php

namespace App\Http\Controllers;

use App\Carts;
use App\Products;
use App\Redemption;
use App\RedemptionUsers;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        $products = Products::inRandomOrder()->get();
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
        $query = "SELECT p.id, p.name,c.count,p.price,p.details FROM carts c inner join products p on p.id =c.product_id inner join users u on u.id=c.user_id where u.id=" . $user . "";
        $items = DB::select($query);
        $total = DB::select("select SUM(p.price) as price from carts c inner join products p on p.id=c.product_id where c.user_id=" . $user . "");
        return view('checkout', ['items' => $items, 'total' => $total[0]->price, 'count' => count($items)]);
    }

    /**
     * Removing item from the cart
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public static function removeItem(Request $request)
    {
        $item_id = $request->get('id');
        $user = Auth::id();
        $removed = Carts::where('product_id', '=', $item_id)->where('user_id', '=', $user)
            ->delete();
        if ($removed) {
            return response()->json(['message' => 'Successfully removed', 'status' => Response::$statusTexts['200'], 'code' => Response::HTTP_OK], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Something went wrong', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);

    }


    /**
     * Checking redemption code
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function checkCode(Request $request)
    {
        $code = strtolower($request->get('code'));
        $code_exists = Redemption::where('code', $code)->first();
        if (!$code_exists) {
            return response()->json(['message' => 'Enter a valid code', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        $user_redeemed = RedemptionUsers::where('code', $code)->where('user_id', Auth::id())->first();
        if ($user_redeemed) {
            return response()->json(['message' => 'Already used', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }


        /**
         * Doesn't make sense till I am keeping track of the cart
         */
//        $redemption_user = new RedemptionUsers();
//        $redemption_user->user_id = Auth::id();
//        $redemption_user->code = $code;
//        $redemption_user->percentage = $code_exists->percentage;
//        $is_saved = $redemption_user->save();
//        if ($is_saved) {
//            return response()->json(['message' => 'Successfully applied code ' . $code_exists->code, 'name' => $code_exists->code, 'percentage' => $code_exists->percentage, 'status' => Response::$statusTexts['200'], 'code' => Response::HTTP_OK], Response::HTTP_OK);
//        }
//        return response()->json(['message' => 'Something went wrong', 'status' => Response::$statusTexts['400'], 'code' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);


        return response()->json(['message' => 'Successfully applied code ' . $code_exists->code, 'name' => $code_exists->code, 'percentage' => $code_exists->percentage, 'status' => Response::$statusTexts['200'], 'code' => Response::HTTP_OK], Response::HTTP_OK);
    }
}
