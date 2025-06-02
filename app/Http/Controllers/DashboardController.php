<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\DB;




class DashboardController extends Controller
{
    public function index()
    {
        $orderCount = DB::table('orders')->count();
        $itemCount = DB::table('items')->count();
        $categoryCount = DB::table('categories')->count();
        $orderRevenue = DB::table('orders')->sum('total_amount');

        return view('admin.dashboard', [
            'orderCount' => $orderCount,
            'itemCount' => $itemCount,
            'categoryCount' => $categoryCount,
            'orderRevenue' => $orderRevenue,
        ]);
    }
}