<?php

namespace App\Messenger\Catalog;

class UpdateProduct
{
    public function __construct(public readonly string $product, readonly ?string $name, public readonly ?int $price) {}
}