<?php

namespace App\Http\Controllers;

use App\Http\Resources\SalesResource;
use App\Models\Product;
use App\Models\Sales;
use App\Services\ProductService;
use Illuminate\Http\Request;

class SalesController extends Controller
{

    public function index()
    {
        $product = Product::where('primary_product', ProductService::PRODUCT_PRIMARY)->first();
        return view('sales')->with(['product' => $product]);
    }


    public function fetchSales(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $type = $request->get('type');
        $sales = ProductService::getSales($type ?? null,100)->load('product');

        // Return as a collection of SalesResource
        return SalesResource::collection($sales);
    }
}
