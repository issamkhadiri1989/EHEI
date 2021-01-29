<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Payment;
use App\Entity\Sticker;
use App\Utils\Fuel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class StickerType extends AbstractType
{
    /**
     * @var \App\Service\Payment
     */
    private $service;

    public function __construct(\App\Service\Payment $service)
    {
        $this->service = $service;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('registrationNumber', TextType::class, [
                'label' => 'Registration number',
            ])
            ->add('year', ChoiceType::class, [
                'choices' => $this->getYears(),
            ])
            ->add('fuel', ChoiceType::class, [
                'label' => 'Fuel type',
                'choices' => $this->getFuels(),
            ])
            ->add('fiscalPower')
            ->add('circulationDate')
            ->add('payment', PaymentType::class)
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                /** @var Payment $payment */
                $payment = $event->getData()
                    ->getPayment();
                $payment->setPaymentDate(new \DateTime())
                    ->setTransactionId(\uniqid())
                    ->setPenality($this->service->getPenality($payment))
                ;
                $form = $event->getForm();
                $form->getData()->setPayment($payment);
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sticker::class,
        ]);
    }

    /**
     * @return array a set of fuels
     */
    private function getFuels()
    {
        $fuels = [];
        foreach (Fuel::getAcceptedFuelChoices() as $fuel) {
            $fuels[$fuel] = $fuel;
        }

        return $fuels;
    }

    /**
     * @return array a set of years
     */
    private function getYears(): array
    {
        $years = [];
        for ($i = 2018; $i < \date('Y'); $i++) {
            $years[$i] = $i;
        }

        return $years;
    }
}