<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Cart
{
    public const CAPACITY = 3;

    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\OneToMany(mappedBy: 'cart', targetEntity: 'App\Entity\CartProduct', cascade: ['persist'])]
    #[ORM\JoinTable(name: 'cart_product')]
    private Collection $cartProducts;

    public function __construct(string $id)
    {
        $this->id = Uuid::fromString($id);
        $this->cartProducts = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getTotalPrice(): int
    {
        return array_reduce(
            $this->cartProducts->toArray(),
            static fn(int $total, CartProduct $product): int => $total + $product->getProduct()->getPrice(),
            0
        );
    }

    public function isFull(): bool
    {
        return $this->cartProducts->count() >= self::CAPACITY;
    }

    public function getProducts(): iterable
    {
        return $this->cartProducts->map(
            static fn(CartProduct $cartProduct): Product => $cartProduct->getProduct()
        );
    }

    public function hasProduct(CartProduct $product): bool
    {
        return $this->cartProducts->contains($product);
    }

    public function addProduct(Product $product): void
    {
        $this->cartProducts->add(new CartProduct($this, $product));
    }

}
