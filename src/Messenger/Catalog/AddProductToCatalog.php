<?php

namespace App\Messenger\Catalog;

class AddProductToCatalog
{
    public function __construct(public readonly string $name, public readonly int $price) {}
}