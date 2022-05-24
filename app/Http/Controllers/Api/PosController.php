<?php

namespace App\Http\Controllers\Api;

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
}
