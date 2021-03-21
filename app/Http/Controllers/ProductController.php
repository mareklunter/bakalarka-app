<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()->products()->paginate(10);

        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productCategories = auth()->user()->productCategories;

        return view('products.create', [
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'price'         => 'required',
            'category'      => 'required',
            'description'   => 'required'
        ]);

        $request->user()->products()->create([
            'name'                  => $request->name,
            'price'                 => $request->price,
            'product_category_id'   => $request->category,
            'description'           => $request->description
        ]);

        return redirect(route('products.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $productCategories = auth()->user()->productCategories()->withTrashed()->get();

        return view("products.edit", [
            'product'           => $product,
            'productCategories' => $productCategories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name'          => 'required',
            'price'         => 'required',
            'category'      => 'required',
            'description'   => 'required'
        ]);

        $product->name                  = $request->name;
        $product->price                 = $request->price;
        $product->product_category_id   = $request->category;
        $product->description           = $request->description;

        $product->save(); 

        return redirect(route('products.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back();
    }
}
