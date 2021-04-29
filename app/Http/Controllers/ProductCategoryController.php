<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productCategories = auth()->user()->productCategories()->paginate(10);

        return view('productCategories.index', [
            'productCategories' => $productCategories
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|max:20',
        ]);

        $request->user()->productCategories()->create([
            'categoryName'  => $request->name
        ]);

        return redirect(route('productCategories.index'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();
        return back();
    }
}
