<?php

namespace App\Form\Type;

use App\Entity\CirculationTax;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CirculationTaxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('driver', DriverType::class);

    }

    public function getParent()
    {
        return EditTaxType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'validation_groups' => ['groupA', 'groupB', 'groupC'],
            'data_class' => CirculationTax::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
