<?php

declare(strict_types=1);

namespace App\Entity;

//<editor-fold desc="use statements">
use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
//</editor-fold>

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull(
     *     message="The price is mandatory."
     * )
     * @Assert\Positive(
     *     message="The price should be > 0."
     * )
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\Positive(
     *     message="Please provide a value of penality > 0."
     * )
     * @ORM\Column(type="float")
     */
    private $penality;

    /**
     * @Assert\Date(
     *     message="The payment date is invalid."
     * )
     * @ORM\Column(type="datetime")
     */
    private $paymentDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $transactionId;

    //<editor-fold desc="setters / getters">
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPenality(): ?float
    {
        return $this->penality;
    }

    public function setPenality(float $penality): self
    {
        $this->penality = $penality;

        return $this;
    }

    public function getPaymentDate(): ?\DateTimeInterface
    {
        return $this->paymentDate;
    }

    public function setPaymentDate(\DateTimeInterface $paymentDate): self
    {
        $this->paymentDate = $paymentDate;

        return $this;
    }

    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    public function setTransactionId(string $transactionId): self
    {
        $this->transactionId = $transactionId;

        return $this;
    }
    //</editor-fold>
}
