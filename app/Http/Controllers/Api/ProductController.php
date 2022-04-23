<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Model\Product;
use App\Http\Controllers\Controller;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::join('categories', 'products.category_id', 'categories.id')
                    ->join('suppliers', 'products.supplier_id', 'suppliers.id')
                    ->select('categories.category_name', 'suppliers.name', 'products.*')
                    ->orderBy('products.id', 'DESC')
                    ->get();
                    
        return response()->json($product);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'product_name' => 'required|max:255',
            'product_code' => 'required|unique:products|max:255',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'buying_price' => 'required|numeric',
            'selling_price' => 'required|numeric',
            'buying_date' => 'required',
            'product_quantity' => 'required|numeric',
        ]);

        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
   
            $name = time().".".$ext;
            $img = Image::make($request->image)->resize(240,200);
            $upload_path = 'backend/product/';
            $image_url = $upload_path.$name;
            $img->save($image_url);
   
            $product = new Product;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->stock = $request->stock;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->product_quantity = $request->product_quantity;
            $product->buying_date = $request->buying_date;
            $product->image = $image_url;
            $product->save(); 
        }else{
            $product = new Product;
            $product->product_name = $request->product_name;
            $product->product_code = $request->product_code;
            $product->category_id = $request->category_id;
            $product->supplier_id = $request->supplier_id;
            $product->stock = $request->stock;
            $product->buying_price = $request->buying_price;
            $product->selling_price = $request->selling_price;
            $product->product_quantity = $request->product_quantity;
            $product->buying_date = $request->buying_date;
            $product->save(); 
   
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->first();

        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = array(

            'product_name' => $request->product_name,
            'product_code' => $request->product_code,
            'category_id' => $request->category_id,
            'supplier_id' => $request->supplier_id,
            'stock' => $request->stock,
            'buying_price' => $request->buying_price,
            'selling_price' => $request->selling_price,
            'product_quantity' => $request->product_quantity,
            'buying_date' => $request->buying_date
        );
       
        $image = $request->newimage;

        if ($image) {
         $position = strpos($image, ';');
         $sub = substr($image, 0, $position);
         $ext = explode('/', $sub)[1];

         $name = time().".".$ext;
         $img = Image::make($image)->resize(240,200);
         $upload_path = 'backend/product/';
         $image_url = $upload_path.$name;
         $success = $img->save($image_url);
         
         if ($success) {
            $data['image'] = $image_url;
            $img = Product::where('id',$id)->first();
            $image_path = $img->image;
            $done = unlink($image_path);
            Product::where('id', $request->id)->update($data);
        }
          
        }else{
            $oldimage = $request->image;
            $data['image'] = $oldimage;
            Product::where('id', $request->id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::where('id', $id)->first();
        $photo = $product->image;

        if($photo) {
            unlink($photo);
           Product::where('id', $product->id)->delete();
        }else{
           Product::where('id', $product->id)->delete();
        }
    }

    public function stockUpdate(Request $request, $id)
    {
        $data = array(
            'product_quantity' => $request->product_quantity
        );

        Product::where('id', $id)->update($data);
    }
}
