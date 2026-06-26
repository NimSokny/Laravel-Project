<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::query()->where('status', true)
            ->with(['category', 'brand', 'images']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->get('brand'));
        }

        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_low'  => $query->orderBy('price'),
            'price_high' => $query->orderByDesc('price'),
            'name_asc'   => $query->orderBy('name'),
            default      => $query->latest(),
        };

        $perPage = (int) ($request->get('per_page', 12));
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Products retrieved',
            'data'    => $products->items(),
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
            'total'        => $products->total(),
            'per_page'     => $products->perPage(),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::where('slug', $slug)
            ->where('status', true)
            ->with(['category', 'brand', 'images'])
            ->firstOrFail();

        return $this->success($product, 'Product retrieved');
    }

    public function featured(): JsonResponse
    {
        $products = Product::where('status', true)
            ->with(['category', 'brand', 'images'])
            ->orderByDesc('id')
            ->limit(8)
            ->get();

        return $this->success($products, 'Featured products');
    }

    public function categories(): JsonResponse
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'image']);

        return $this->success($categories, 'Categories');
    }

    public function brands(): JsonResponse
    {
        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'logo']);

        return $this->success($brands, 'Brands');
    }
}
