<?php

namespace App\Repository;

use App\Entity\Product;
use App\Service\Catalog\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Ramsey\Uuid\Uuid;

class ProductRepository implements ProductRepositoryInterface
{
    private EntityRepository $repository;

    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
        $this->repository = $this->entityManager->getRepository(Product::class);
    }

    public function getProducts(int $page = 0, int $count = 3): iterable
    {
        return $this->repository->createQueryBuilder('p')
            ->setMaxResults($count)
            ->setFirstResult($page * $count)
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getTotalCount(): int
    {
        return $this->repository->createQueryBuilder('p')->select('count(p.id)')->getQuery()->getSingleScalarResult();
    }

    public function exists(string $productId): bool
    {
        return $this->repository->find($productId) !== null;
    }

    public function add(string $name, int $price): Product
    {
        $product = new Product(Uuid::uuid4(), $name, $price, new \DateTimeImmutable());

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product;
    }

    public function remove(string $id): void
    {
        $product = $this->repository->find($id);
        if ($product !== null) {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        }
    }
}
