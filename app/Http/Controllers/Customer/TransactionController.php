<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function myTransaction()
    {
        $myTransactions = Transaction::where('id', Auth::id())->get();

        return response()->json($myTransactions);
    }

    public function transaction()
    {
       $transactions = Transaction::with('product')->where('user_id', auth()->user()->id)->get();

       $finalData = [];

       $amount = 0;

       if(isset($ $transactions))
       {
          foreach($ $transactions as $transaction)
          {

            if($transaction->product)
            {

               foreach($transaction->product as $orderProduct)
               {

                  if($orderProduct->id == $transaction->product_id)
                  {

                    $finalData[$transaction->product_id] ['id'] = $orderProduct->id;
                    $finalData[$transaction->product_id] ['name'] = $orderProduct->name;
                    $finalData[$transaction->product_id] ['quantity'] = $transaction->quantity;
                    $finalData[$transaction->product_id] ['price'] = $transaction->price;
                    $finalData[$transaction->product_id] ['discount'] = $transaction->discount;
                    $finalData[$transaction->product_id] ['sub_total'] = $transaction->quantity * $transaction->price;
                    $amount += $transaction->quantity * $transaction->price;
                    $finalData['Total_amount'] = $amount;

                  }

               }
              
            }

          }
         // dd($carts);
       }

       return response()->json($finalData);
       
    }
}
