<?php

namespace App\Entity;

use App\Repository\CartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CartRepository::class)
 */
class Cart
{
    const CART_CREATED = 1;
    const CART_CANCELED = 2;
    const CART_SHIPPED = 3;

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTimeInterface
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @var mixed
     * @ORM\OneToMany(targetEntity=CartLine::class, mappedBy="cart", orphanRemoval=true)
     */
    private $cartLines;

    public function __construct()
    {
        $this->cartLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|CartLine[]
     */
    public function getCartLines(): Collection
    {
        return $this->cartLines;
    }

    public function addCartLine(CartLine $cartLine): self
    {
        if (!$this->cartLines->contains($cartLine)) {
            $this->cartLines[] = $cartLine;
            $cartLine->setCart($this);
        }

        return $this;
    }

    public function removeCartLine(CartLine $cartLine): self
    {
        if ($this->cartLines->removeElement($cartLine)) {
            // set the owning side to null (unless already changed)
            if ($cartLine->getCart() === $this) {
                $cartLine->setCart(null);
            }
        }

        return $this;
    }
}
