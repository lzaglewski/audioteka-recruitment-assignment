<?php

namespace App\Repository;

use App\Entity\Cart;
use App\Entity\Product;
use App\Service\Cart\CartInterface;
use App\Service\Cart\CartService;
use App\Service\CartProduct\CartProductService;
use Doctrine\ORM\EntityManagerInterface;
use Ramsey\Uuid\Uuid;

class CartRepository implements CartService
{
    private CartProductService $cartProductService;

    public function __construct(private readonly EntityManagerInterface $entityManager, CartProductService $cartProductService)
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

    public function create(): CartInterface
    {
        $cart = new Cart(Uuid::uuid4()->toString());

        $this->entityManager->persist($cart);
        $this->entityManager->flush();

        return $cart;
    }
}