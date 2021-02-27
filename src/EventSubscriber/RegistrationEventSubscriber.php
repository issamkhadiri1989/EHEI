<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use App\Event\NewRegistrationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RegistrationEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            NewRegistrationEvent::NAME => [
                ['newRegistration', 0],
            ],
            //... Other events
        ];
    }

    public function newRegistration(NewRegistrationEvent $event)
    {
        //... We can put the send email code here.
        dump('test etst');
    }
}