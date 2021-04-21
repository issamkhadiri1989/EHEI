<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Item;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class)
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'query_builder' => function (ProductRepository $repository) {
                        return $repository->createQueryBuilder('p')
                            ->orderBy('p.label', 'ASC');
                },
                'choice_label' => 'label',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
            'label' => false,
        ]);
    }
}
