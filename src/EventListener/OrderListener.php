<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Event\OrderPlaced;
use Twig\Environment;

class OrderListener
{
    /**
     * @var Environment
     */
    private $twig;
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(Environment $twig, \Swift_Mailer $mailer)
    {
        $this->twig = $twig;
        $this->mailer = $mailer;
    }

    //order.checked_out
    public function onOrderCheckedOut(OrderPlaced $placedEvent)
    {
        $cart = $placedEvent->getOrder();
        $template = $this->twig->render('email/order_placed.html.twig', [
            'customer_name' => $cart->getFirstName(),
        ]);
        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody($template, 'text/html');
        $this->mailer->send($message);
    }

    public function maMethod(OrderPlaced $orderPlacedEvent)
    {
        // ... my logic
        dump(__CLASS__.'::'.__FUNCTION__);

    }
}