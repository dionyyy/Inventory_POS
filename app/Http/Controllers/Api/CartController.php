<?php

namespace App\Http\Controllers\Api;

use App\Models\Model\Pos;
use App\Models\Model\Extra;
use Illuminate\Http\Request;
use App\Models\Model\Product;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function addToCart(Request $request, $id){

        $product = Product::where('id', $id)->first();

        $check = Pos::where('pro_id', $id)->first();

        if ($check) {
            Pos::where('pro_id', $id)->increment('pro_quantity');

            $prod = Pos::where('pro_id', $id)->first();
            $subtotal = $prod->pro_quantity * $prod->product_price;
    
            Pos::where('pro_id',$id)->update(['sub_total'=> $subtotal]);
        }else{
            $data = array(
                'pro_id' => $id,
                'pro_name' => $product->product_name,
                'pro_quantity' => 1,
                'product_price' => $product->selling_price,
                'sub_total' => $product->selling_price,
            );
    
            Pos::insert($data);
        }
    }

    public function cartProduct()
    {
        $cart = Pos::all();

        return response()->json($cart);
    }

    public function removeCart($id)
    {
        Pos::where('id', $id)->delete();
    }

    public function increment($id)
    {
        $product = Pos::where('id', $id)->first();
        
        $quantity = Pos::where('id', $id)->increment('pro_quantity');
        
        $subtotal = $product->pro_quantity * $product->product_price;

  	    Pos::where('id',$id)->update(['sub_total'=> $subtotal]);

        return response("done");
    }

    public function decrement($id)
    {
        $product = Pos::where('id', $id)->first();

        if($product->pro_quantity <= 1){
            Pos::where('id', $id)->delete();
        }

        $quantity = Pos::where('id', $id)->decrement('pro_quantity');
        
        $subtotal = $product->pro_quantity * $product->product_price;

  	    Pos::where('id',$id)->update(['sub_total'=> $subtotal]);

        return response("done");
    }

    public function vats()
    {
        $vat = Extra::first();

        return response()->json($vat);
    }
}