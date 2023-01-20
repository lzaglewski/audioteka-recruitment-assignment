<?php

namespace App\Service\CartProduct;

use App\Service\Cart\CartInterface;
use App\Service\Catalog\ProductInterface;

interface CartProductInterface
{
    public function getCart(): CartInterface;
    public function getProduct(): ProductInterface;
}