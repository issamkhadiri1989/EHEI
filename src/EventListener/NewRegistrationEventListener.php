<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\NewRegistrationEvent;

class NewRegistrationEventListener
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param NewRegistrationEvent $event The new registration event
     */
    public function onNewRegistrationPlaced(NewRegistrationEvent $event)
    {
        $message = \sprintf(
            '<html><body>
<h1>New registration </h1>
<p>Dear %s, you have successfully  registered as %s.</p>
</body></html>',
            $event->getRegistration()->getFullname(),
            $event->getRegistration()->getUsername()
        );

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody($message, 'text/html')
        ;

        $this->mailer->send($message);

        $event->stopPropagation();
    }
}