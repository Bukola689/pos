<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function allOrder()
    {
        $orders = Order::orderBy('id', 'desc')->get();

        return response()->json($orders);
    }
}
