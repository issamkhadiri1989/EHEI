<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Cart;
use Symfony\Contracts\EventDispatcher\Event;

class OrderPlaced extends Event
{
    const NAME = 'order.checked_out';

    /**
     * @var Cart
     */
    private $order;

    public function __construct(Cart $order)
    {
        $this->order = $order;
    }

    /**
     * @return Cart
     */
    public function getOrder(): Cart
    {
        return $this->order;
    }
}