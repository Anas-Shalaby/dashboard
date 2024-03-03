<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders = Order::whereHas('client' , function($q) use ($request) {
            return $q->where('name','like' , '%'.$request->search.'%');
        })->paginate(5);

        return view('dashboard.orders.index',compact('orders' ));
    }

    public function products (Order $order){
        $products = $order->products;
        return view('dashboard.orders._products',compact('products' , 'order'));
    }

    public function destroy(Order $order ){


        // delete order
        foreach ($order->products as $product){


            $product->update([
               'stock' => $product->stock + $product->pivot->quantity
            ]);

        }// end of foreach

        $order->update([
            'isCanceled' => true
        ]);






        session()->flash('success' , __('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }// end of destroy

    public function updateStatus(Request $request,Order $order){
        $order->update([
            'status' => 'finished'
        ]);

        $orders = Order::whereHas('client' , function($q) use ($request) {
            return $q->where('name','like' , '%'.$request->search.'%');
        })->paginate(5);


        return redirect()->route('dashboard.orders.index' , $orders);

    }
}
