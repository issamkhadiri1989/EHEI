<?php

declare(strict_types=1);

namespace App\Model;

class Contact
{
    /** @var string */
    private $name;
    /** @var string */
    private $email;
    /** @var string */
    private $message;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return Contact
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Contact
     */
    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     *
     * @return Contact
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }


}