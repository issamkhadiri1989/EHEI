<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class Quantity extends Constraint
{
    public $message = 'The quantity exceeds {{ limit }}';
}