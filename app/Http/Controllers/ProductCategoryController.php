<?php

namespace App\Http\Controllers;

use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
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
        $user_id = $request->user()->id;
        $this->validate($request, [
            'name'  => "required|max:20|unique:product_categories,categoryName,NULL,id,deleted_at,NULL,user_id,$user_id",
        ]);

        $is_trashed = $request->user()->productCategories()->onlyTrashed()->get()->where('categoryName', '=', $request->name)->first();

        if($is_trashed) {

            $is_trashed->deleted_at = null;
            $is_trashed->save(); 

        } else {

            $request->user()->productCategories()->create([
                'categoryName'  => $request->name
            ]);

        }
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
