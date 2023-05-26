<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\Cart;
use App\Http\Requests\StoreOrderDetailsRequest;
use App\Http\Requests\UpdateOrderDetailsRequest;
use App\Models\Product;
use App\Repository\Customer\OrderDetails\OrderDetailRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class OrderDetailsController extends Controller
{

  public $orderDetail;

  public function __construct(OrderDetailRepository $orderDetail)
  {
    $this->orderDetail = $orderDetail;
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $orderDetails = OrderDetails::where('id', 'desc')->get();

       return response()->json($orderDetails);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function checkout()
    {
     
        $old_cartitems = Cart::where('user_id', Auth::id())->get();

        foreach($old_cartitems as $item)
        {
            if(!Product::where('id', $item->product_id)->where('quantity', '>=', $item->quantity)->exists())
            {
                $removeitem = Cart::where('user_id', Auth::id())->where('product_id', $item->product_id)->first();
                $removeitem->delete();
            }
        }

        $cartitems = Cart::where('user_id', Auth::id())->get();

        return response()->json($cartitems);

    }

    public function placeOrder(Request $request)
    {  
        $data = $request->validate([
            'first_name',
            'last_name',
            'email',
            'phone_number',
            'address1',
            'address2',
            'country',
            'state',
            'city'
        ]);

        $this->orderDetail->storeOrderDetail($request, $data);

        Cache::put('order', $data);

        return response()->json([
            'status' => true,
            'message' => 'Order Made Successfully !',
        ]);
       
    }


}
