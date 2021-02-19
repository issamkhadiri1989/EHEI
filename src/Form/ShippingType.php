<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Country;
use App\Entity\Shipping;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Full name',
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Address',
            ])
            ->add('country', EntityType::class, [
                'placeholder' => 'Choose an option',
                'class' => Country::class,
                'label' => 'Country',
                'choice_label' => 'name',
                'mapped' => false,
            ])
            ->add('state', ChoiceType::class, [
                'choices' => [],
                'label' => 'State',
                'mapped' => false,
                'placeholder' => 'Choose an option',
            ])
            ->add('city', ChoiceType::class, [
                'choices' => [],
                'label' => 'City',
                'placeholder' => 'Choose an option',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Shipping::class,
        ]);
    }
}
