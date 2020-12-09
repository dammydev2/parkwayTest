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
        return \Cart::add(array(
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

    public function removeFromCart($request)
    {
        return \Cart::remove($request->id);
    }

    public function updateCart()
    {
        return \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
    }

    public function clearCart()
    {
        \Cart::clear();
    }
}
