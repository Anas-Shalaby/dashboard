<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function details(Client $client , Order $order){
        $category = Category::FindOrFail($order->products->first()->category_id);

        return view('dashboard.clients.orders.details' , compact('client' , 'order' , 'category'));

    }// end of index

    public function create(Client $client , Order $order){
        $categories = Category::all();
        return view('dashboard.clients.orders.create' , compact('categories' , 'client') );

    }// end of create

    public function store(Request $request , Client $client){

        $request->validate([
           'products' => 'required|array',
           'quantaties' => 'required|array',
        ]);

        $order = $client->orders()->create([]);

        $total_price = 0;

        foreach ($request->products as $index=>$product){
            $order->products()->attach($product , ['quantity' => $request->quantaties[$index]]);
            $product = Product::FindOrFail($product);

            $total_price += ($product->sale_price - $product->discount_count)  * $request->quantaties[$index] ;

            $order->total_price = $total_price;
            $order->save();
            $product->update([
                'stock' => $product->stock - $request->quantaties[$index]
            ]);

        }


        session()->flash('success' , __('site.added_successfully'));


        return redirect()->route('dashboard.orders.index');


    }// end of store

    public function edit(Client $client , Order $order){

        return view('dashboard.clients.orders.edit',  compact('client' , 'order'));

    }// end of edit

    public function update(Request $request , Client $client , Order $order){

            foreach ($order->products as $product){

                $product->update([
                   'stock' => $product->stock +  $product->pivot->quantity
                ]);

            }

            $order->delete();


        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required',
        ]);

            $order = $client->orders()->create([]);

        $order->products()->attach($request->product , ['quantity' => $request->quantity]);

        $product = Product::FindOrFail($request->product);

        $total_price = 0;

        $total_price += ($product->sale_price - $product->discount_count ) * $request->quantity;

        $order->total_price = $total_price;

        $order->save();

        $product->update([
            'stock' => $product->stock - $request->quantity
        ]);

        $client->update([
           'name' => $request->name,
           'phone' => $request->phone,
           'address' => $request->address,
        ]);


        session()->flash('success' , __('site.updated_successfully'));


        return redirect()->route('dashboard.orders.index');



    }// end of update

    public function destroy(Client $client , Order $order){

    }// end of destroy

}// end of controller
