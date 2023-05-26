<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\OrderDetails;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Cart::orderBy('id', 'desc')->get();
        $orders = Order::all();
        $transaction = Transaction::all();

        return response()->json([$products, $orders, $transaction]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //return $request->all();

    
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

             DB::transaction(function () use ($request) {

                $order = new Order();
                $order->name = $request->name;
                $order->phone = $request->phone;
                $order->save();
        
                $order_id = $order->id;
        
                //order_details//
        
                 $cartitems = Cart::orderBy('id', 'asc')->get();
        
                    foreach($cartitems as $cartitem)
                     {
                        OrderDetails::create([
                            'order_id' => $order->id,
                            'product_id' => $cartitem->product_id,
                            'quantity' => $cartitem->quantity,
                            'price' => $cartitem->price,
                            'discount' =>  $cartitem->discount,
                            'amount' => $cartitem->quantity * $cartitem->price / $cartitem->discount,
                        ]);
                     }
        
        
                // transaction //
        
                Transaction::create([
                    'order_id' => $order->id,
                    'paid_amount' => $request->paid_amount,
                    'payment_method' => $request->payment_method,
                    'trans_amount' => $request->trans_amount,
                    'balance' => $request->paid_amount - $request->trans_amount,
                    'user_id' => 1,
                    'trans_date' => Carbon::now(),
        
                ]);
        
        
                $products = Cart::orderBy('id', 'desc')->get();;
                $order_detail = OrderDetails::where('order_id', $order_id)->get();
                $order = Order::where('id', $order_id)->get();
        
        
               return response()->json([
                'product' => $products,
                'order detail' => $order_detail,
                'order' => $order
               ]);
        
               return response()->json([
                'message' => 'Product Order Fail To Insert! Check Your Input'
               ]);
        
                 });
   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrderRequest  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function search($search)
    {
        $orders = Order::where('title', 'LIKE', '%' . $search . '%')->orderBy('id', 'desc')->get();
        if($orders) {
            return response()->json([
                'success' => true,
                'orders' => $orders
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'orders not found'
            ]);
        }
    }
}
