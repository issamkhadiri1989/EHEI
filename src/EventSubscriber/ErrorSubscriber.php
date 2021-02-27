<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ErrorSubscriber
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processError' , 1],
                ['logData',  0],
            ],
        ];
    }

    public function processError(ExceptionEvent $event)
    {
        dump('processError');
    }

    public function logData(ExceptionEvent $event)
    {
        dump('logData');
    }
}
