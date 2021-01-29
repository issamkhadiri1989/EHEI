<?php

declare(strict_types=1);

namespace App\Service;

class Payment
{
    /**
     * Computes the amout of the penality when the payment exceeds the max date.
     *
     * @param \App\Entity\Payment $payment the sticker payment
     *
     * @return float the total amount of the penality
     */
    public function getPenality(\App\Entity\Payment $payment): float
    {
        $p = 0.0;
        //... Do some logic

        return $p;
    }
}