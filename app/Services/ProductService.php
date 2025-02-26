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

}
