<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Product;
use App\Service\Cart\CartRepositoryInterface;
use App\Service\CartProduct\CartProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CartRepository implements CartRepositoryInterface
{
    private CartProductRepositoryInterface $cartProductService;

    public function __construct(private readonly EntityManagerInterface $entityManager, CartProductRepositoryInterface $cartProductService)
    {
        $this->cartProductService = $cartProductService;
    }

    public function addProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if (!$cart || !$product) {
            return;
        }

        $cart->addProduct($product);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();

    }

    public function removeProduct(string $cartId, string $productId): void
    {
        $cart = $this->entityManager->find(Cart::class, $cartId);
        $product = $this->entityManager->find(Product::class, $productId);

        if (!$cart || !$product) {
            return;
        }

        $cartProduct = $this->cartProductService->getOneByProduct($product);

        if (!$cartProduct) {
            return;
        }

        $this->entityManager->remove($cartProduct);
        $this->entityManager->persist($cart);
        $this->entityManager->flush();
    }

    public function create(?string $uuid = null): Cart
    {
        if (!$uuid) {
            $uuid = Uuid::uuid4()->toString();
        }

        $cart = new Cart($uuid);

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}