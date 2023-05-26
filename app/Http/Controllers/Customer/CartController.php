<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->orderBy('id', 'desc')->get();

        return response()->json([
            'status' => true,
            'carts' => $carts
        ]);
    }

    public function store(Request $request)
    {
        $product_id = $request->input('product_id');

        if(Auth::id())
        {
          $product = Product::where('id',$product_id)->first();
  
          if($product) 
          {
           
            if(Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists())
            {
              return response()->json(['message' => $product->name, "Exist in Your Cart"]);
            }
  
            else{
              $order = new Cart();
              $order->product_id = $product_id;
              $order->quantity = $product->quantity;
              $order->price = $product->price;
              $order->discount = $product->discount;
              $order->user_id = Auth::id();
              $order->save();
  
              return response()->json(['message' => 'Cart added successfully']);
            } 
          }   
        }
    }

    public function increment(Request $request)
    {

      $product_id = $request->input('product_id');

      if(Auth::id())
      {

        $product_id = $request->input('product_id')->first();

        if(Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists())
        {
        
        $cart = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        dd($cart);

       $cart = Cache::increment('quantity', 1);

        return response()->json([
          'status' => true,
          'cart' => $cart
        ]);

       }
 
      }
    }


    public function decrement(Request $request)
    {
  
     if(Auth::id())
      {
        
        $product_id = $request->input('product_id');

        if(Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists())
        {
        
        $order = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();

        $order->decrement('quantity', 1); 

        return response()->json([
          'status' => true,
          'order' => $order
        ]);

       }

        }
  
    }

    public function removeCart(Request $request)
    {
      if(Auth::check())
      {
        
        $product_id = $request->input('product_id');

        if(Cart::where('product_id', $product_id)->where('user_id', Auth::id())->exists())
        {
        
        $order = Cart::where('product_id', $product_id)->where('user_id', Auth::id())->first();
        $order = $order->delete(); 

        return response()->json([
          'status' => true,
          'message' => 'Cart removed Successfully'
        ]);

       } else {
        
         return response()->json([
          'status' => 'Logi to Continue',
         ]);
       }

        }
    }

   

    public function getCartForOrderDetail()
    {
 
     $cartItems = Cart::where('user_id', auth()->user()->id)->get();
 
     $finalData = [];
 
     $amount = 0;
 
     if(isset($cartItems))
     {
         foreach($cartItems as $cartitem)
         {
 
             if($cartitem->product)
             {
 
               //dd($cartitem->product);
               
                 foreach($cartitem->product as $cartProduct)
                 {
                     if($cartProduct->id == $cartitem->product_id)
 
                     {
 
                     $finalData[$cartitem->product_id] ['id'] = $cartProduct->id;
                     $finalData[$cartitem->product_id] ['name'] = $cartProduct->name;
                     $finalData[$cartitem->product_id] ['quantity'] = $cartitem->quantity;
                     $finalData[$cartitem->product_id] ['price'] = $cartitem->price;
                     $finalData[$cartitem->product_id] ['discount'] = $cartitem->discount;
                     $finalData[$cartitem->product_id] ['total'] = $cartitem->price * $cartitem->quantity;
                     $amount += $cartitem->selling_price * $cartitem->quantity / $cartitem->discount;
                     $finalData['totalAmount'] = $amount;
 
                     }
                     //var_dump($cartProduct->id);
 
                 }
             }
         }
     }
     
     return response()->json($finalData);
    }


}
