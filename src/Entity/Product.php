<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
class Product
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private UuidInterface $id;

    #[ORM\Column(type: 'string', length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(type: 'integer', nullable: false)]
    private string $priceAmount;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private \DateTimeImmutable $createdAt;

    public function __construct(string $id, string $name, int $price, \DateTimeImmutable $createdAt)
    {
        $this->id = Uuid::fromString($id);
        $this->name = $name;
        $this->priceAmount = $price;
        $this->createdAt = $createdAt;
    }

    public function getId(): string
    {
        return $this->id->toString();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->priceAmount;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function setPrice(int $price): void
    {
        $this->priceAmount = $price;
    }
}
