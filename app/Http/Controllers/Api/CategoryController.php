<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'image']);

        return $this->success($categories, 'Categories');
    }
}
