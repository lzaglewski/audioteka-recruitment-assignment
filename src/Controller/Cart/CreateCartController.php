<?php

namespace App\Controller\Cart;

use App\Messenger\Cart\CreateCart;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", methods={"POST"}, name="cart-create")
 */
class CreateCartController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function __invoke(): Response
    {
        $uuid = Uuid::uuid4()->toString();
        $this->messageBus->dispatch(new CreateCart($uuid));

        return new JsonResponse(['cart_id' => $uuid], Response::HTTP_CREATED);
    }
}
