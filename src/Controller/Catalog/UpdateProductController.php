<?php

namespace App\Controller\Catalog;


use App\Messenger\Catalog\UpdateProduct;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products/{product}", methods={"PATCH"}, name="product-update")
 */
class UpdateProductController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder        $errorBuilder,
        private readonly MessageBusInterface $messageBus
    )
    {
    }

    public function __invoke(?Request $request, $product,): Response
    {
        $name = null;
        $price = null;

        if ($request->get('name')) {
            $name = trim($request->get('name'));
            if ($name === '') {
                return new JsonResponse(
                    $this->errorBuilder->__invoke('Invalid name.'),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        if ($request->get('price')) {
            $price = (int)$request->get('price');
            if ($price < 1) {
                return new JsonResponse(
                    $this->errorBuilder->__invoke('Invalid price.'),
                    Response::HTTP_UNPROCESSABLE_ENTITY
                );
            }
        }

        $this->messageBus->dispatch(new UpdateProduct($product, $name, $price));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}