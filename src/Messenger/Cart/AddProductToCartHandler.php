<?php

namespace App\Messenger\Cart;

use App\Service\Cart\CartRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartRepositoryInterface $service) { }

    public function __invoke(AddProductToCart $command): void
    {
        $this->service->addProduct($command->cartId, $command->productId);
    }
}