<?php

namespace App\Controller\Catalog;

use App\ResponseBuilder\CartBuilder;
use App\ResponseBuilder\ProductListBuilder;
use App\Service\Catalog\ProductProvider;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products", methods={"GET"}, name="product-list")
 */
class ListController extends AbstractController
{
    private const MAX_PER_PAGE = 3;

    /**
     * @param ProductProvider $productProvider
     * @param ProductListBuilder $productListBuilder
     */
    public function __construct(private readonly ProductProvider $productProvider, private readonly ProductListBuilder $productListBuilder) { }

    /**
     * @param Request $request
     * @param CartBuilder $cartBuilder
     * @return Response
     */
    public function __invoke(Request $request, CartBuilder $cartBuilder): Response
    {
        $page = max(0, (int)$request->get('page', 0));

        $products = $this->productProvider->getProducts($page, self::MAX_PER_PAGE);
        $totalCount = $this->productProvider->getTotalCount();

        return new JsonResponse(
            $this->productListBuilder->__invoke($products, $page, self::MAX_PER_PAGE, $totalCount),
            Response::HTTP_OK
        );
    }
}
