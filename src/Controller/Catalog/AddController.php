<?php

namespace App\Controller\Catalog;

use App\Messenger\Catalog\AddProductToCatalog;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"POST"}, name="product-add")
 */
class AddController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder        $errorBuilder,
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        $name = trim($request->get('name'));
        $price = (int)$request->get('price');

        if ($name === '' || $price < 1) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Invalid name or price.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->messageBus->dispatch(new AddProductToCatalog($name, $price));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}