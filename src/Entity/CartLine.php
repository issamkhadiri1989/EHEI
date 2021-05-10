<?php

namespace App\Entity;

use App\Repository\CartLineRepository;
use App\Validator\Quantity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=CartLineRepository::class)
 */
class CartLine
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Quantity()
     * @var int
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @var ?Cart
     * @ORM\ManyToOne(targetEntity=Cart::class, inversedBy="cartLines")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cart;

    /**
     * @var ?Product
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCart(): ?Cart
    {
        return $this->cart;
    }

    public function setCart(?Cart $cart): self
    {
        $this->cart = $cart;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function reduceQuantity()
    {
        if ($this->getProduct()->getQuantity() > $this->getQuantity())  {
            $this->getProduct()
                ->setQuantity($this->getProduct()->getQuantity() - $this->getQuantity());
        }
    }
}
