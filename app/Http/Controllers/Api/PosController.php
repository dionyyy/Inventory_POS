<?php

namespace App\Http\Controllers\Api;

use DateTime;
use App\Models\Model\Pos;
use Illuminate\Http\Request;
use App\Models\Model\Product;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function getProduct($id)
    {
        $product = Product::where('category_id', $id)->get();

        return response()->json($product);
    }

    public function orderDone(Request $r)
    {
        $validate = $r->validate([
            'customer_id' => 'required',
            'payby' => 'required'
        ]);

        $data = array(
            'customer_id' => $r->customer_id,
            'qty' => $r->qty,
            'sub_total' => $r->subTotal,
            'vat' => $r->vat,
            'total' => $r->total,
            'pay' => $r->pay,
            'due' => $r->due,
            'payby' => $r->payby,
            'order_date' => date('d/m/Y'),
            'order_month' => date('F'),
            'order_year' => date('Y')
        );

        $order_id = DB::table('orders')->insertGetId($data);

        $contents = Pos::all();

        $odata = array();
        foreach ($contents as $content) {
            $odata['order_id'] = $order_id;
            $odata['product_id'] = $content->pro_id;
            $odata['pro_quantity'] = $content->pro_quantity;
            $odata['product_price'] = $content->product_price;
            $odata['sub_total'] = $content->sub_total;

            DB::table('order_details')->insert($odata);

            Product::where('id', $content->pro_id)
            ->update(['product_quantity' => DB::raw('product_quantity -' .$content->pro_quantity)]);
        }

        DB::table('pos')->delete();
        return response('Done');
    }

    public function searchOrderDate(Request $r)
    {
        $orderDate = $r->date;
        $newDate = new DateTime($orderDate);
        $done = $newDate->format('d/m/Y');

        $order = DB::table('orders')
            ->join('customers', 'orders.customer_id','customers.id')
            ->select('customers.name', 'orders.*')
            ->where('orders.order_date', $done)
            ->get();

        return response()->json($order);
    }

    public function todaySell()
    {
        $date = date('d/m/Y');
        $sell = DB::table('orders')->where('order_date', $date)->sum('total');

        return response()->json($sell);
    }

    public function todayIncome()
    {
        $date = date('d/m/Y');
        $income = DB::table('orders')->where('order_date', $date)->sum('pay');

        return response()->json($income);
    }

    public function todayDue()
    {
        $date = date('d/m/Y');
        $due = DB::table('orders')->where('order_date', $date)->sum('due');

        return response()->json($due);
    }

    public function todayExpense()
    {
        $date = date('d/m/Y');
        $due = DB::table('expenses')->where('expenses_date', $date)->sum('amount');

        return response()->json($due);
    }

    public function todayStockOut()
    {
        $product = DB::table('products')->where('product_quantity', '<', '1')->get();

        return response()->json($product);
    }
}
