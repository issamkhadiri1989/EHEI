<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ShippingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address', TextType::class, [
                'required' => false,
                'mapped' => true,
                'attr' => [
                    'placeholder' => 'Address',
                ],
            ])
            ->add('country', CountryType::class, [
                'required' => false,
                'placeholder' => 'Country',
                'attr' => [
                    'placeholder' => 'Country',
                ],
            ])
            ->add('state', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'State',
                ],
            ])
            ->add('zipCode', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Zip code',
                ],
            ])
            ->add('city', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'City',
                ],
            ])
            ->add('firstName', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'First name',
                ],
            ])
            ->add('lastName', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Last name',
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Email',
                ],
            ])
            ->add('phone', TelType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Phone number',
                ],
            ]);
    }

    /**
     * Overrides the default blog name.
     *
     * @return string the block name
     */
    public function getBlockPrefix()
    {
        return 'shipping_type';
    }
}