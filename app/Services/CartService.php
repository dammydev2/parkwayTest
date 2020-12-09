<?php

namespace App\Services;

use App\Models\Product;

class CartService
{

    public function __construct(
        Product $product
    ) 
    {
        $this->product = $product;
    }

    public function allProducts()
    {
        return $this->product->all();
    }
}
