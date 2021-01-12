<?php

declare(strict_types=1);

namespace App\Entity;

//<editor-fold desc="Use statements">
use App\Repository\StickerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

use App\Validator\Constraints as MyValidator;

//</editor-fold>

/**
 * @MyValidator\ConstraintUpperCase()
 * @ORM\Entity(repositoryClass=StickerRepository::class)
 */
class Sticker
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * The registration Number should match 99999-A-99 and should not be empty
     *
     * @Assert\NotBlank(
     *     message="The registration number is blank. You should provide a valid data."
     * )
     * @Assert\NotNull(
     *     message="Field Registration Number is mandatory"
     * )
     * @Assert\Regex(
     *     pattern="/^(\d+){5}-(\w+){1}-(\d+){1,2}$/",
     *     message="The registration number {{ value }} is invalid.",
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $registrationNumber;

    /**
     * @Assert\NotNull(
     *     message="The Year is mandatory."
     * )
     * @Assert\NotBlank(
     *     message="The year field should not be blank."
     * )
     * @ORM\Column(type="integer")
     */
    private $year;

    /**
     * @Assert\Choice(
     *     callback={"App\Utils\Fuel", "getAcceptedFuelChoices"},
     *     message="{{ value }} is not a valid choice."
     * )
     * @ORM\Column(type="string", length=255)
     */
    private $fuel;

    /**
     * @ORM\Column(type="integer")
     */
    private $fiscalPower;

    /**
     * @ORM\Column(type="date")
     */
    private $circulationDate;

    /**
     * @Assert\Valid()
     * @ORM\OneToOne(targetEntity=Payment::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $payment;

    /**
     * @Assert\Collection(
     *     extraFieldsMessage="The field {{ field }} is not recognized",
     *     missingFieldsMessage="The field {{ field }} is missing",
     *     fields={
     *          "driver_name" = @Assert\Optional(
     *              @Assert\NotBlank(
     *                  message="The driver name is mandatory."
     *              )
     *          ),
     *          "driver_card" = @Assert\Required({
     *              @Assert\NotNull(
     *                      message="Please provide the visa card infos."
     *              ),
     *              @Assert\CardScheme(
     *                  schemes={"VISA"},
     *                  message="Your credit card number {{ value }} is invalid. "
     *              )
     *          })
     *    }
     * )
     */
    private $driver;

    /**
     * @Assert\All({
     *      @Assert\NotBlank(),
     *      @Assert\Length(
     *          min="10",
     *          minMessage="The value you provided is less than {{ limit }}.",
     *          max="15",
     *          maxMessage="The value you provided exceeds the limit of {{ limit }}."
     *      )
     * })
     */
    private $phoneNumbers;


    /**
     * @MyValidator\ConstraintUpperCase()
     */
    private $driverName;

    /**
     * @param string $driverName The driver full name
     *
     * @return Sticker
     */
    public function setDriverName(string $driverName): self
    {
        $this->driverName = $driverName;

        return $this;
    }

    /**
     * Adds a phone number to the list.
     *
     * @param string $phone The phone number
     *
     * @return Sticker
     */
    public function setPhoneNumber(string $phone): self
    {
        $this->phoneNumbers[] = $phone;

        return $this;
    }

    /**
     * Adds the driver data.
     *
     * @param string $key The option
     * @param string $value The value
     *
     * @return Sticker the current instance
     */
    public function addDriverData(string $key, string $value): self
    {
        $this->driver[$key] = $value;

        return $this;
    }

    //<editor-fold desc="Setters/Getters">
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel(string $fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getFiscalPower(): ?int
    {
        return $this->fiscalPower;
    }

    public function setFiscalPower(int $fiscalPower): self
    {
        $this->fiscalPower = $fiscalPower;

        return $this;
    }

    public function getCirculationDate(): ?\DateTimeInterface
    {
        return $this->circulationDate;
    }

    public function setCirculationDate(\DateTimeInterface $circulationDate): self
    {
        $this->circulationDate = $circulationDate;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
    //</editor-fold>

    /**
     * Returns the accepted fuel choices.
     *
     * @return array The accepted choices for fuel
     */
    public function getAcceptedFuelChoices(): array
    {
        return [
            'Diesel',
            'Gasoline',
            'Hybrid',
            'Electric',
        ];
    }
}
