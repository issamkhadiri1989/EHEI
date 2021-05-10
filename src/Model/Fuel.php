<?php

declare(strict_types=1);

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

abstract class Fuel
{
    public static function getFuels()
    {
        return [
            'Gasoline',
            'Diesel',
            'Hybrid',
        ];
    }
}