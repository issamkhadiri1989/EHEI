<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Line;
use App\Form\DataTransformer\ProductTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LineType extends AbstractType
{
    /**
     * @var ProductTransformer
     */
    private $transformer;

    public function __construct(ProductTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product', TextType::class)
            ->add('quantity', TextType::class)
            ->add('unitPrice', TextType::class);

        $builder->get('product')
            ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Line::class,
        ]);
    }
}
