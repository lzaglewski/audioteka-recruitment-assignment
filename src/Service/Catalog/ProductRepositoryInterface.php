<?php

namespace App\Service\Catalog;

use App\Entity\Product;

interface ProductRepositoryInterface
{
    public function add(string $name, int $price): Product;

    public function remove(string $id): void;

    /**
     * @return Product[]
     */
    public function getProducts(int $page = 0, int $count = 3): iterable;

    public function exists(string $productId): bool;

    public function getTotalCount(): int;

    public function update(string $product, ?string $name, ?int $price);
}