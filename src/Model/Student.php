<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Student
{
    /**
     * @Assert\NotNull(message="This is mandatory")
     * @Assert\Length(
     *     min="3",
     *     max="10",
     *     minMessage="The name should have at least {{ limit }} you provided {{ value }}",
     *     maxMessage="The name should not exceed {{ limit }}  you provided {{ value }}"
     * )
     * @var string|null
     */
    private $fullName;
    /**
     * @var int|null
     */
    private $age;
    /**
     * @var string|null
     */
    private $phone;
    /**
     * @var string|null
     */
    private $email;

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @param string|null $fullName
     */
    public function setFullName(?string $fullName): void
    {
        $this->fullName = $fullName;
    }

    /**
     * @return int|null
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * @param int|null $age
     */
    public function setAge(?int $age): void
    {
        $this->age = $age;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     */
    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

}