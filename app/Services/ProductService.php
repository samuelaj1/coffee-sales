<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Sales;

class ProductService
{
    const PRODUCT_PRIMARY = 1;
    const SHIPPING_COST = 10;


    // Method to fetch previous sales based on product type or all sales
    public static function getSales($type = null, $limit = 5)
    {
        $query = Sales::latest()->take($limit);

        // Apply filter for primary product sales
        if ($type === self::PRODUCT_PRIMARY) {
            $query->whereHas('product', function ($productQuery) {
                $productQuery->where('primary_product', self::PRODUCT_PRIMARY);
            });
        }

        return $query->get(['id', 'product_id', 'quantity', 'unit_cost', 'selling_price', 'created_at']);
    }

    // calculate selling price
    public static function calculatePrice(float $quantity, float $unitCost, $productId=null): array
    {
        $cost = $quantity * $unitCost;

        // Fetch the product
        $product  = $productId
            ? Product::findOrFail($productId)
            : Product::where('primary_product', self::PRODUCT_PRIMARY)->first();

        // Use the product's profit margin or default to 10% if not set
        $profitMargin = $product ? ($product->profit_margin / 100) : 0.10;

        // Calculate the selling price
        $sellingPrice = ($cost / (1 - $profitMargin)) + self::SHIPPING_COST;

        return [
            'product_id'=>$product->id,
            'selling_price' => round($sellingPrice, 2),
        ];
    }

}
