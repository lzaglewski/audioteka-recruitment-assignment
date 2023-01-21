<?php

namespace App\Messenger\Cart;

class RemoveProductFromCart
{
    public function __construct(public readonly string $cartId, public readonly string $productId) {}
}