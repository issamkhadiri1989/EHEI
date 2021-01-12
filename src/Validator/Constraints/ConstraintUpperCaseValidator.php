<?php

declare(strict_types=1);

namespace App\Validator\Constraints;

use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Constraint;

class ConstraintUpperCaseValidator extends ConstraintValidator
{
    /**
     * @param mixed      $objet      The object being validated
     * @param Constraint $constraint The constraint to be analysed
     */
    public function validate($objet, Constraint $constraint)
    {
        if (null === $objet->getDriverName() || '' === $objet->getDriverName()) {
            return;
        }

        if (!\preg_match('/^[A-Z]+$/', $objet->getDriverName(), $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $objet->getDriverName())
                ->atPath('driverName')
                ->addViolation();
        }
    }
}

