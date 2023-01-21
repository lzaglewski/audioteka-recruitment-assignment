<?php

namespace App\Service\CartProduct;

use App\Entity\CartProduct;
use App\Entity\Product;

interface CartProductRepositoryInterface
{
    public function getOneByProduct(Product $product): ?CartProduct;

}