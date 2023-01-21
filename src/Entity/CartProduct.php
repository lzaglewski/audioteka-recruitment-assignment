<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

#[ORM\Entity]
class CartProduct
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', nullable: false)]
    private $id;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Cart', inversedBy: 'cartProducts')]
    #[ORM\JoinColumn(nullable: false)]
    private Cart $cart;

    #[ORM\ManyToOne(targetEntity: 'App\Entity\Product')]
    #[ORM\JoinColumn(name: 'product_id', referencedColumnName: 'id')]
    private Product $product;

    public function __construct(Cart $cart, Product $product)
    {
        $this->id = Uuid::uuid4();
        $this->cart = $cart;
        $this->product = $product;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

}
