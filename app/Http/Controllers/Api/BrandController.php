<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::where('status', true)
            ->orderBy('name')
            ->get(['id', 'name', 'slug', 'logo']);

        return $this->success($brands, 'Brands');
    }
}
