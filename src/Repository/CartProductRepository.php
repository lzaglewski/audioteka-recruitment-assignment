<?php

namespace App\Repository;

use App\Entity\CartProduct;
use App\Entity\Product;
use App\Service\CartProduct\CartProductInterface;
use App\Service\CartProduct\CartProductService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

class CartProductRepository implements CartProductService
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(CartProduct::class);
    }

    /**
     * @throws NonUniqueResultException
     */
    public function getOneByProduct(Product $product): ?CartProductInterface
    {
        $query = $this->repository->createQueryBuilder('cp')
            ->where('cp.product = :product')
            ->setParameter('product', $product)
            ->setMaxResults(1);

        return $query->getQuery()->getOneOrNullResult();
    }

}