<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Resources\Product as ProductResource;
use App\Http\Resources\ProductCollection;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $products = ProductResource::collection(Product::all());

        return $products;
        
        # return view('product.index')->with('products', $product);
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
    public function store(ProductRequest $request)
    {   
        $product = new ProductResource( Product::create([
            "name" => $request->input('data.attributes.name'),
            "price" => $request->input('data.attributes.price')
        ]) );

        // if (request()->ajax()) {
        return $product;
        // }

        // return redirect()->to(route('product.index'))->with('status', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
      //  if (request()->ajax()) {
        //return response()->json(new ProductResource($product), 200);
       // }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill([
            "name" => $request->input('data.attributes.name'),
            "price" => $request->input('data.attributes.price')
        ]);
        $product->save();
        // if (request()->ajax()) {
        return new ProductResource($product);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

      //  if (request()->json()) {
            return new ProductResource($product);
       // }
    }
}
