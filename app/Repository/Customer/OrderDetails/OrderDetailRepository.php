<?php

namespace App\Repository\Customer\OrderDetails;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderDetailRepository implements IOrderDetailRepository
{

   public function  storeOrderDetail(Request $request, array $data)
   {
        DB::transaction(function () use($request){

           $order = new Order(); 
           $order->first_name = $request->input('first_name');
           $order->last_name = $request->input('last_name');
           $order->email = $request->input('email');
           $order->phone_number = $request->input('phone_number');
           $order->address1 = $request->input('address1');
           $order->address2 = $request->input('address2');
           $order->country = $request->input('country');
           $order->state = $request->input('state');
           $order->city = $request->input('city');
           $order->pincode = '20'.rand(111111,999999);
           $order->tracking_no = '01'.rand(1111,9999);
           $order->save();     
   
           $cartitems = Cart::where('user_id', Auth::id())->get();
   
   
           foreach($cartitems as $item)
           {
              
                OrderDetails::create([
                   'order_id' => $order->id,
                   'product_id' => $item->product_id,
                   'quantity' => $item->quantity,
                   'price' => $item->price,
                   'discount' => $item->discount,
                  
               ]);
   
           }
   
           if (Auth::user()->address1 == NULL)
           {
               $user = User::where('id', Auth::id())->first();
               $user->first_name = $request->input("first_name");
               $user->last_name = $request->input("last_name");
               $user->email = $request->input('email');
               $user->phone_number = $request->input("phone_number");
               $user->address1 = $request->input('address1');
               $user->address2 = $request->input('address2');
               $user->country = $request->input('country');
               $user->state = $request->input('state');
               $user->city = $request->input('city');
               $user->pincode = 'pincode-' .rand(111111, 999999);
               $user->tracking_no = 'tracking-'.rand(11111,99999);
               $user->user_id = Auth::user()->id;
               $user->update();
           }

           //event(new SaveOrder($order));
      
       });
   }

   // public function updateOrderDetail(Request $request, OrderDetails $orderDetail, array $data)

   // public function deleteOrderDetail(OrderDetails $orderDetail)

}