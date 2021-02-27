<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Registration;
use Symfony\Contracts\EventDispatcher\Event;

class NewRegistrationEvent extends Event
{
    public const NAME = 'new.registration.placed';

    /**
     * @var Registration
     */
    private $registration;

    public function __construct(Registration $registration)
    {
        $this->registration = $registration;
    }

    /**
     * @return Registration
     */
    public function getRegistration(): Registration
    {
        return $this->registration;
    }
}
