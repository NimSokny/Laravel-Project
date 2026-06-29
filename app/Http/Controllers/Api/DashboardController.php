<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrands = Brand::count();
        $totalOrders = Order::count();
        $totalUsers = User::count();
        $pendingOrders = Order::where('order_status', 'Pending')->count();

        return $this->success([
            'products' => $totalProducts,
            'categories' => $totalCategories,
            'brands' => $totalBrands,
            'orders' => $totalOrders,
            'users' => $totalUsers,
            'pendingOrders' => $pendingOrders,
        ], 'Dashboard stats retrieved successfully');
    }
}
