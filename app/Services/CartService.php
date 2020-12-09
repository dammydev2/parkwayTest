<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Coupon;

class CartService
{

    protected $product, $coupon;
    public function __construct(
        Product $product,
        Coupon $coupon
    ) {
        $this->product = $product;
        $this->coupon = $coupon;
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
        return \Cart::update(
            $request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            )
        );
    }

    public function clearCart()
    {
        \Cart::clear();
    }

    public function confirmCoupon(array $credentials)
    {
        // check if coupon exist
        $chkCoupon = $this->coupon->where('coupon', $credentials['coupon'])->first();
        if (!$chkCoupon) {
            return false;
        }
        $min_price = $chkCoupon->min_price;
        $min_item = $chkCoupon->min_item;
        // getting the number of items(s) and total price in the cart
        $num_of_items = \Cart::getTotalQuantity();
        $total = \Cart::getTotal();
        // checking if coupon condition is met
        if ($num_of_items > $min_item && $total > $min_price) {
            // for     - Coupon FIXED10:
                $newTotal = 0;
            if ($credentials['coupon'] === 'FIXED10') {
                $newTotal = $total - 10;
            }
            //     - Coupon PERCENT10:
            if ($credentials['coupon'] === 'PERCENT10') {
                $newTotal = $total - (10/100 * $total);
            }
            //     - Coupon MIXED10
            if ($credentials['coupon'] === 'MIXED10') {
                $total1 = $total - (10/100 * $total);
                $total2 = $total - 10;
                $newTotal = min($total1, $total2);
            }
            //     - Coupon REJECTED10
            if ($credentials['coupon'] === 'REJECTED10') {
                $newTotal = $total - ((10/100 * $total) + 10);
                // $total2 = $total - 10;
                // dd($total2);
                // $newTotal = ($total) - ($total1 + $total2);
            }
            return $newTotal;
        } else {
            return false;
        }
    }
}
