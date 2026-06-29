<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $pendingOrders = Order::where('order_status', 'Pending')->count();
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', compact(
            'totalProducts',
            'totalCategories',
            'totalBrands',
            'totalOrders',
            'totalUsers',
            'pendingOrders',
            'recentOrders'
        ));
    }
}
