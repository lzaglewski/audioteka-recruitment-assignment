<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UpdateProductHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $service) { }

    public function __invoke(UpdateProduct $command): void
    {
        $this->service->update($command->product, $command->name, $command->price);
    }
}