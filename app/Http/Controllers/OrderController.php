<?php

namespace App\Http\Controllers;

use App\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $timePeriod = 'today')
    {
        $strTimePeriod = $timePeriod;
        switch ($timePeriod) {
            case 'today':
                $timePeriod = Carbon::today();
                break;
            case 'week':
                $timePeriod = Carbon::today()->subDays(7);
                break;
            case 'month':
                $timePeriod = Carbon::today()->subMonth();
                break;
            case 'all':
                $timePeriod = '0000-00-00';
                break;
        }

        $orders = auth()->user()->orders()->where('created_at', '>', $timePeriod)->sortable()->paginate(10);

        return view('orders.index', compact('orders', 'strTimePeriod'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = auth()->user()->products;
        $tables = auth()->user()->tables;

        return view('orders.create', compact('products', 'tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'product'       => 'required',
            'amount'        => 'required',
            'orderPrice'    => 'required',
            'table_id'      => 'nullable'
        ]);

        //create order and add it to user
        $order = new Order([
            'price'     => $request->orderPrice,
            'table_id'  => $request->table_id,
        ]);
        
        $request->user()->orders()->save($order);

        //add products to order - M:N relationship - fill pivot table
        foreach ($request->product as $index => $product_id) {
            $product = auth()->user()->products->find($product_id);

            for ($j = 0; $j < $request->amount[$index]; $j++) {
                $order->products()->attach($product, [
                    //we save current name and price to pivot table, because product can be edited in the future 
                    'product_name'  => $product->name,
                    'product_price' => $product->price,
                ]);
            }
        }

        $this->updateTables();

        return redirect(route('orders.index'));
    }


    /**
     * Show the form for editing the specified resource. 
     */
    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        
        //redirect to index when order paid
        if ($order->paid) {
            return redirect(route('orders.index'));
        }

        $products = auth()->user()->products()->withTrashed()->get();
        $tables = auth()->user()->tables;

        //Count duplicate values of an given array:
        $order_items = array_count_values($order->products()->withTrashed()->get()->pluck('id')->toArray()); 

        return view('orders.edit', [
            'order'         => $order,
            'tables'        => $tables,
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
        $this->authorize('update', $order);
        
        $this->validate($request, [
            'product'       => 'required',
            'amount'        => 'required',
            'orderPrice'    => 'required',
            'table_id'      => 'nullable'
        ]);
        //add-remove order products - M:N relationship - edit pivot table
        foreach ($request->product as $index => $product_id) {

            $product = auth()->user()->products->find($product_id);

            $order->products()->detach();

            //add products to order - M:N relationship - fill pivot table
            foreach ($request->product as $index => $product_id) {
                $product = auth()->user()->products->find($product_id);

                for ($j = 0; $j < $request->amount[$index]; $j++) {
                    $order->products()->attach($product, [
                        //we save current name and price to pivot table, because product can be edited in the future 
                        'product_name'  => $product->name,
                        'product_price' => $product->price
                    ]);
                }
            }
        }

        $order->price = $request->orderPrice;
        $order->table_id = $request->table_id;
        $order->save();
        
        $this->updateTables();

        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        $this->updateTables();

        return back();
    }

    /**
     * Get order bill
     */
    public function getBill(Order $order)
    {
        $order_items = array_count_values($order->products()->withTrashed()->get()->pluck('id')->toArray()); 

        $view = view('orders.bill', compact('order', 'order_items'))->render();
        return $view;
    }

    /**
     * Change order status
     */
    public function pay(Order $order)
    {
        $order->paid = !($order->paid);
        $order->save();

        $this->updateTables();

        return back();
    }


    /**
     * Update tables status
     */
    public function updateTables()
    {
        $tables = auth()->user()->tables;
        foreach ($tables as $table) {
            if( $table->orders->where('paid', false)->isEmpty() ) {
                $table->occupied = false;
            } else {
                $table->occupied = true;
            }
            $table->save();
        }
    }

}
