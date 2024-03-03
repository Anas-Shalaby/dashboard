<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $products_count = Product::count();
        $categories_count = Category::count();
        $orders_count = Order::count();
        $clients_count = Client::count();
        $users_count = User::whereHasRole('admin')->count();

        $sales_data = DB::table('orders')->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_price'),
        )->groupBy('month')->where('isCanceled', false)->get();



        $sales = DB::table('orders')->select(
            DB::raw('SUM(total_price) as total_price'),
        )->where('isCanceled', false)->get();


        return view('dashboard.index', compact('products_count', 'categories_count', 'orders_count', 'clients_count', 'users_count', 'sales_data', 'sales'));
    } // end of index
}
