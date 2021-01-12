<?php

declare(strict_types=1);

namespace App\Utils;

class Fuel
{
    /**
     * Returns the accepted fuel choices.
     *
     * @return array The accepted choices for fuel
     */
    public static function getAcceptedFuelChoices(): array
    {
        return [
            'Diesel',
            'Gasoline',
            'Hybrid',
            'Electric',
        ];
    }
}
