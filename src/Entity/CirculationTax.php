<?php

namespace App\Entity;

use App\Repository\CirculationTaxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @UniqueEntity(
 *     fields={"registrationNumber", "year"},
 *     errorPath="registrationNumber",
 *     message="you have already paid the tax for this car"
 * )
 * @ORM\Entity(repositoryClass=CirculationTaxRepository::class)
 */
class CirculationTax
{
    const FUELS = ['DIESEL', 'GASOLINE'];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull(groups={"groupA", "groupB"})
     * @ORM\Column(type="string", length=255)
     */
    private $registrationNumber;

    /**
     *
     * @Assert\NotNull(
     *     groups={"groupA"}
     * )
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @Assert\NotNull(groups={"groupA"})
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @Assert\NotNull(groups={"groupA"})
     * @ORM\Column(type="integer")
     */
    private $horsePower;

    /**
     * @Assert\Choice(callback={"App\Model\Fuel", "getFuels"}, groups={"groupA"})
     * @ORM\Column(type="string", length=255)
     */
    private $fuel;

    /**
     * @var array[]
     * @Assert\Unique()
     * Assert\All({
     *   Assert\Image(
     *      mimeTypes={"image/png", "image/jpeg"},
     *      maxHeight="200",
     *      minHeight="100"
     *   )
     * })
     */
    private $hobbies;

    /**
     * @var Driver
     *
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity=Driver::class, inversedBy="circulationTax", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $driver;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(?string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(?int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getHorsePower(): ?int
    {
        return $this->horsePower;
    }

    public function setHorsePower(?int $horsePower): self
    {
        $this->horsePower = $horsePower;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(?string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function addHobby(?string $hobby): self
    {
        $this->hobbies[] = $hobby;

        return $this;
    }

    /**
     * @Assert\Callback()
     *
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public function isPriceValid(ExecutionContextInterface $context, $payload): void
    {
        $price = null;
        switch ($this->getFuel()) {
            case 'Gasoline':
                if ($this->getHorsePower() < 8) {
                    $price = 350.0;
                } elseif ($this->getHorsePower() >= 8 && $this->getHorsePower() < 11) {
                    $price = 750.0;
                } else {
                    $price = 1500.0;
                }
                break;
            case 'Diesel':
                if ($this->getHorsePower() < 8) {
                    $price = 750.0;
                } elseif ($this->getHorsePower() >= 8 && $this->getHorsePower() < 11) {
                    $price = 1500.0;
                } else {
                    $price = 3000.0;
                }
                break;
            default:
                break;
        }
        if ($this->getPrice() !== $price) {
            $context->buildViolation('the price you provided {{ value }} is not valid')
                ->setParameter('{{ value }}', $this->getPrice())
                ->atPath('price')
                ->addViolation();
        }
    }

    /**
     * @param $object
     * @param ExecutionContextInterface $context
     * @param $payload
     */
    public static function isValidPrice($object, ExecutionContextInterface $context, $payload): void
    {
        $price = null;
        switch ($object->getFuel()) {
            case 'Gasoline':
                if ($object->getHorsePower() < 8) {
                    $price = 350.0;
                } elseif ($object->getHorsePower() >= 8 && $object->getHorsePower() < 11) {
                    $price = 750.0;
                } else {
                    $price = 1500.0;
                }
                break;
            case 'Diesel':
                if ($object->getHorsePower() < 8) {
                    $price = 750.0;
                } elseif ($object->getHorsePower() >= 8 && $object->getHorsePower() < 11) {
                    $price = 1500.0;
                } else {
                    $price = 3000.0;
                }
                break;
            default:
                break;
        }
        if ($object->getPrice() !== $price) {
            $context->buildViolation('the price {{ value }} is not valid please try again')
                ->setParameter('{{ value }}', $object->getPrice())
                ->atPath('price')
                ->addViolation();
        }
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $callback = function ($object, ExecutionContextInterface $context, $payload)
        {
            $price = null;
            switch ($object->getFuel()) {
                case 'Gasoline':
                    if ($object->getHorsePower() < 8) {
                        $price = 350.0;
                    } elseif ($object->getHorsePower() >= 8 && $object->getHorsePower() < 11) {
                        $price = 750.0;
                    } else {
                        $price = 1500.0;
                    }
                    break;
                case 'Diesel':
                    if ($object->getHorsePower() < 8) {
                        $price = 750.0;
                    } elseif ($object->getHorsePower() >= 8 && $object->getHorsePower() < 11) {
                        $price = 1500.0;
                    } else {
                        $price = 3000.0;
                    }
                    break;
                default:
                    break;
            }
            if ($object->getPrice() !== $price) {
                $context->buildViolation('the price {{ value }} is not valid please try again')
                    ->setParameter('{{ value }}', $object->getPrice())
                    ->atPath('price')
                    ->addViolation();
            }
        };
        $metadata->addConstraint(new Assert\Callback($callback));
    }

    public function getDriver(): ?Driver
    {
        return $this->driver;
    }

    public function setDriver(Driver $driver): self
    {
        $this->driver = $driver;

        return $this;
    }
}
