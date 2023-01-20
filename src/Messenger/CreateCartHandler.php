<?php

namespace App\Messenger;

use App\Service\Cart\CartInterface;
use App\Service\Cart\CartService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class CreateCartHandler implements MessageHandlerInterface
{
    public function __construct(private readonly CartService $service) { }

    public function __invoke(CreateCart $command): CartInterface
    {
        return $this->service->create();
    }
}
