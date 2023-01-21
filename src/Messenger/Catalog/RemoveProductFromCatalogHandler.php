<?php

namespace App\Messenger\Catalog;

use App\Service\Catalog\ProductRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class RemoveProductFromCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private readonly ProductRepositoryInterface $service) { }

    public function __invoke(RemoveProductFromCatalog $command): void
    {
        $this->service->remove($command->productId);
    }
}
