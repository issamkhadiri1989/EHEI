<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\CirculationTax;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditTaxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registrationNumber')
            ->add('year')
            ->add('price')
            ->add('horsePower')
            ->add('fuel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => ['groupA', 'groupB'],
            'data_class' => CirculationTax::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}