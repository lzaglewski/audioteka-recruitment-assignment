<?php

namespace App\Service\CartProduct;

use App\Entity\Product;

interface CartProductService
{
    public function getOneByProduct(Product $product): ?CartProductInterface;

}