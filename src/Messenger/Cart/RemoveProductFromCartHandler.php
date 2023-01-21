<?php

namespace App\Messenger\Cart;

use App\Service\Cart\CartRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartRepositoryInterface $service) { }

    public function __invoke(RemoveProductFromCart $command): void
    {
        $this->service->removeProduct($command->cartId, $command->productId);
    }
}
