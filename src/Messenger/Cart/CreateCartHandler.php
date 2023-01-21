<?php

namespace App\Messenger\Cart;

use App\Entity\Cart;
use App\Service\Cart\CartRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartRepositoryInterface $service) { }

    public function __invoke(CreateCart $command): Cart
    {
        return $this->service->create($command->uuid);
    }
}
