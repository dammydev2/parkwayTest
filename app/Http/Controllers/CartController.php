<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(
        CartService $cartService
    ) {
        $this->cartService = $cartService;
    }

    public function shop()
    {
        $products = $this->cartService->allProducts();
        // dd($products->toArray());
        return view('shop')->withTitle('E-COMMERCE STORE | SHOP')->with(['products' => $products]);
    }

    public function cart()  {
        $cartCollection = \Cart::getContent();
        // dd($cartCollection);
        return view('cart')->withTitle('E-COMMERCE STORE | CART')->with(['cartCollection' => $cartCollection]);;
    }

    public function add(Request $request){
        $cart = $this->cartService->addToCart($request);
        return redirect()->route('cart.index')->with('success_msg', 'Item is Added to Cart!');
    }

    public function remove(Request $request){
        \Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    public function update(Request $request){
        \Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
        ));
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    public function clear(){
        \Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Cart is cleared!');
    }
}
