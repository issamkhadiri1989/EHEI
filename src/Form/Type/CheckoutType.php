<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Cart;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shipping', ShippingType::class, [
                'mapped' => false,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                $shipping = $event->getData();
                if (isset($shipping['shipping']) === true) {
                    $shipping = $shipping['shipping'];
                    /** @var Cart $cart */
                    $cart = $event->getForm()->getData();
                    $cart->setZipCode($shipping['zipCode'])
                        ->setCity($shipping['city'])
                        ->setState($shipping['state'])
                        ->setAddress($shipping['address'])
                        ->setPhone($shipping['phone'])
                        ->setLastName($shipping['lastName'])
                        ->setFirstName($shipping['firstName'])
                        ->setCountry($shipping['country']);
                    $event->getForm()->setData($cart);
                }
            })
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Cart::class,
            'label' => false,
        ]);
    }
}