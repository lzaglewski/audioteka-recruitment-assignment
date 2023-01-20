<?php

namespace App\Service\Cart;

use App\Service\Catalog\ProductInterface;

interface CartInterface
{
    public function getId(): string;
    public function getTotalPrice(): int;
    public function isFull(): bool;
    /**
     * @return ProductInterface[]
     */
    public function getProducts(): iterable;
}
