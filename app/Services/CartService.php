<?php

namespace App\Services;

use App\Models\Product;

class CartService
{

    protected $product;
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

    public function addToCart($request)
    {
        \Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->img,
                'slug' => $request->slug
            )
        ));
    }
}
