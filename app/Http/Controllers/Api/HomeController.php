<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function featured(): JsonResponse
    {
        $products = Product::where('status', true)
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return $this->success($products, 'Featured products');
    }

    public function latest(): JsonResponse
    {
        $products = Product::where('status', true)
            ->with(['category', 'brand', 'images'])
            ->latest()
            ->limit(12)
            ->get();

        return $this->success($products, 'Latest products');
    }

    public function categories(): JsonResponse
    {
        $categories = Category::where('status', true)
            ->withCount('products')
            ->orderBy('name')
            ->get();

        return $this->success($categories, 'Categories');
    }

    public function hero(): JsonResponse
    {
        $hero = [
            'title'       => 'Welcome to Our Store',
            'subtitle'    => 'Discover the best products at the best prices',
            'image'       => null,
            'button_text' => 'Shop Now',
            'button_link' => '/products',
        ];

        return $this->success($hero, 'Hero content');
    }
}
