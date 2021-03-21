<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller 
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = auth()->user()->orders()->paginate(10);

        if ( session('orders') ) {
            $orders = session('orders');
            // $orders = auth()->user()->orders()->orderBy('paid', $sortKey)->paginate(10);
        }

        return view('orders.index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = auth()->user()->products;

        return view('orders.create', [
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product'       => 'required',
            'amount'        => 'required',
            'orderPrice'    => 'required'
        ]);

        //create order and add it to user
        $order = new Order([
            'price' => $request->orderPrice,
            // 'paid'  => true
        ]);
        
        $request->user()->orders()->save($order);

        //add products to order - M:N relationship - fill pivot table
        foreach ($request->product as $index => $product_id) {
            $product = auth()->user()->products->find($product_id);

            for ($j=0; $j < $request->amount[$index]; $j++) { 
                $order->products()->attach($product, [
                    //we save current name and price to pivot table, because product can be edited in the future 
                    'product_name'  => $product->name,
                    'product_price' => $product->price,
                ]);
            }
        }

        return redirect(route('orders.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource. 
     */
    public function edit(Order $order)
    {
        //redirect to index when order paid
        if ( $order->paid ) {
            return redirect(route('orders.index'));
        }

        $products = auth()->user()->products()->withTrashed()->get();

        //Count duplicate values of an given array:
        $order_items = array_count_values( $order->products()->withTrashed()->get()->pluck('id')->toArray() );

        return view('orders.edit', [
            'order'         => $order,
            'order_items'   => $order_items,
            'products'      => $products,
            'index'         => 0
        ]);
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $this->validate($request, [
            'product'       => 'required',
            'amount'        => 'required',
            'orderPrice'    => 'required'
        ]);


        //add-remove products to order - M:N relationship - edit pivot table
        foreach ($request->product as $index => $product_id) {

            $product = auth()->user()->products->find($product_id);

            $order->products()->detach();

            //add products to order - M:N relationship - fill pivot table
            foreach ($request->product as $index => $product_id) {
                $product = auth()->user()->products->find($product_id);

                for ($j=0; $j < $request->amount[$index]; $j++) { 
                    $order->products()->attach($product, [
                        //we save current name and price to pivot table, because product can be edited in the future 
                        'product_name'  => $product->name,
                        'product_price' => $product->price
                    ]);
                }
            }
        }

        $order->price = $request->orderPrice;
        $order->save(); 
        
        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect(route('orders.index'));
    }

    /**
     * Change order status
     */
    public function pay(Order $order)
    {
        $order->paid = !($order->paid);
        $order->save();
        return redirect(route('orders.index'));
    }

    /**
     * Sort Order by status
     */
    public function sortStatus()
    {
        // $orders = auth()->user()->orders();

        $sortKey = session('key', 'asc');


        if ( $sortKey == "asc") {
            session(['key' => 'desc']);
        } else {
            session(['key' => 'asc']);
        }

        $orders = auth()->user()->orders()->orderBy('paid', $sortKey)->paginate(10);
        return redirect(route('orders.index'))->with('orders', $orders);
        // return view('orders.index', [
        //     'orders' => $orders
        // ]);
    }
}
