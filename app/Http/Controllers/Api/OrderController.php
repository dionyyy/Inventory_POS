<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function todayOrder()
    {
        $data = date('d/m/Y');
        $order = DB::table('orders')
        ->join('customers', 'orders.customer_id', 'customers.id')
        ->where('order_date', $data)
        ->select('customers.name', 'orders.*')
        ->orderBy('orders.id', 'DESC')->get();

        return response()->json($order);
    }
}
