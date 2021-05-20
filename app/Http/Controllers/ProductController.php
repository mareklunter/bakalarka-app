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
        $products = auth()->user()->products()->sortable()->paginate(10);

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
        $user_id = $request->user()->id;
        $this->validate($request, [
            'name'          => "required|max:50|unique:products,name,NULL,id,deleted_at,NULL,user_id,$user_id",
            'price'         => 'required',
            'category'      => 'nullable',
            'description'   => 'nullable'
        ]);

        $is_trashed = $request->user()->products()->onlyTrashed()->get()->where('name', '=', $request->name)->first();

        //check if product exist but was deleted, if yes: set deleted_at=NULL and update new values 
        if($is_trashed) {

            $is_trashed->deleted_at            = null;
            $is_trashed->price                 = $request->price;
            $is_trashed->product_category_id   = $request->category;
            $is_trashed->description           = $request->description;

            $is_trashed->save(); 

        } else {

            $request->user()->products()->create([
                'name'                  => $request->name,
                'price'                 => $request->price,
                'product_category_id'   => $request->category,
                'description'           => $request->description
            ]);

        }

        return redirect(route('products.index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        
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
        $this->authorize('update', $product);
        
        $this->validate($request, [
            'name'          => "required|max:50|unique:products,name,$product->id,id,deleted_at,NULL",
            'price'         => 'required',
            'category'      => 'nullable',
            'description'   => 'nullable'
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
