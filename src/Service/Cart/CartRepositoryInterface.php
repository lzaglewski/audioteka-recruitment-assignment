<?php

namespace App\Service\Cart;

use App\Entity\Cart;

interface CartRepositoryInterface
{
    public function addProductIfNotFull(string $cartId, string $productId): void;

    public function removeProduct(string $cartId, string $productId): void;

    public function create(?string $uuid = null): Cart;
}