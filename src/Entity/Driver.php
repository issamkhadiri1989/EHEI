<?php

namespace App\Entity;

use App\Repository\DriverRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=DriverRepository::class)
 */
class Driver
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotNull(groups={"groupA", "groupC"})
     * @ORM\Column(type="string", length=255)
     */
    private $fullName;

    /**
     * @Assert\NotNull(groups={"groupA", "groupC"})
     * @ORM\Column(type="string", length=255)
     */
    private $driverLicense;

    /**
     * @ORM\OneToOne(targetEntity=CirculationTax::class, mappedBy="driver", cascade={"persist", "remove"})
     */
    private $circulationTax;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getDriverLicense(): ?string
    {
        return $this->driverLicense;
    }

    public function setDriverLicense(string $driverLicense): self
    {
        $this->driverLicense = $driverLicense;

        return $this;
    }

    public function getCirculationTax(): ?CirculationTax
    {
        return $this->circulationTax;
    }

    public function setCirculationTax(CirculationTax $circulationTax): self
    {
        // set the owning side of the relation if necessary
        if ($circulationTax->getDriver() !== $this) {
            $circulationTax->setDriver($this);
        }

        $this->circulationTax = $circulationTax;

        return $this;
    }
}
