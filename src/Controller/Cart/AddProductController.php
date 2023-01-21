<?php

namespace App\Controller\Cart;

use App\Entity\Cart;
use App\Entity\Product;
use App\Messenger\Cart\AddProductToCart;
use App\ResponseBuilder\ErrorBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart/{cart}/{product}", methods={"PUT"}, name="cart-add-product")
 */
class AddProductController extends AbstractController
{
    public function __construct(
        private readonly ErrorBuilder        $errorBuilder,
        private readonly MessageBusInterface $messageBus,
    )
    {
    }

    public function __invoke(Cart $cart, Product $product): Response
    {
        if ($cart->isFull()) {
            return new JsonResponse(
                $this->errorBuilder->__invoke('Cart is full.'),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $this->messageBus->dispatch(new AddProductToCart($cart->getId(), $product->getId()));

        return new Response('', Response::HTTP_ACCEPTED);
    }
}
