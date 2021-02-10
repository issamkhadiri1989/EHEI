<?php

declare(strict_types=1);

namespace App\Form\DataTransformer;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class ProductTransformer implements DataTransformerInterface
{
    /**
     * @var ProductRepository
     */
    private $repository;

    /**
     * ProductTransformer constructor.
     *
     * @param ProductRepository $repository
     */
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * transforms a product into a barcode.
     *
     * @param Product|null $value the given product
     *
     * @return string the product's barcode
     */
    public function transform($value)
    {
        if (null === $value) {
            return '';
        }

        return $value->getBarcode();
    }

    /**
     * transforms the barcode to a product.
     *
     * @param string $value the barcode
     *
     * @return Product|null the product instance
     */
    public function reverseTransform($value)
    {
        // It's use when the field is optional
        if (!$value) {
            return;
        }

        //find the object using the entity manager
        $product = $this->repository->findOneByBarcode($value);
        if (null === $product) {
            $exceptionMessage = \sprintf(
                'A product with the given barcode "%s" does not exist',
                $value
            );
            $violationError = 'Product with barcode {{ barcode }} was not found';
            $failure = new TransformationFailedException($exceptionMessage);
            $failure->setInvalidMessage($violationError, [
                '{{ barcode }}' => $value,
            ]);
            throw $failure;
        }

        return $product;
    }
}
