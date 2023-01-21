<?php

namespace App\Messenger\Cart;

class AddProductToCart
{
    public function __construct(public readonly string $cartId, public readonly string $productId) {}
}
