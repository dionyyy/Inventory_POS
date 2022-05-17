<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Model\Product;
use App\Http\Controllers\Controller;

class PosController extends Controller
{
    public function getProduct($id)
    {
        $product = Product::where('category_id', $id)->get();

        return response()->json($product);
    }
}
