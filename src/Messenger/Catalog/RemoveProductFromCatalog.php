<?php

namespace App\Messenger\Catalog;

class RemoveProductFromCatalog
{
    public function __construct(public readonly string $productId) {}
}