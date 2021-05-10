<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\CartLine;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Config\Definition\Exception\InvalidTypeException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class QuantityValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof Quantity) {
            throw new UnexpectedTypeException($constraint, Quantity::class);
        }

        if ('' === $value || null === $value) {
            return;
        }

        if (!\is_int($value)) {
            throw new UnexpectedTypeException($value, 'int');
        }

        if ($value < 0) {
            throw new InvalidTypeException('Quantity must be > 0');
        }

        /** @var CartLine $cartLine */
        $cartLine = $this->context->getObject();

        /** @var Product|null $product */
        $product = $this->manager
            ->getRepository(Product::class)
            ->find($cartLine->getProduct());

        // Check if the requested quantity exceeds the limit.
        if ($value > $product->getQuantity()) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ limit }}', $product->getQuantity())
                ->atPath('quantity')
                ->addViolation();
        }
    }
}