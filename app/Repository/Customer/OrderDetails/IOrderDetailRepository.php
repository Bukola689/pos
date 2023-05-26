<?php

namespace App\Repository\Customer\OrderDetails;

use App\Models\OrderDetails;
use Illuminate\Http\Request;

interface IOrderDetailRepository
{
     public function storeOrderDetail(Request $request, array $data);

     // public function updateOrderDetail(Request $request, OrderDetails $orderDetail, array $data);

     // public function deleteOrderDetail(OrderDetails $orderDetail);
}