<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class AddProductToCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $service) { }

    public function __invoke(AddProductToCatalog $command): void
    {
        $this->service->add($command->name, $command->price);
    }
}