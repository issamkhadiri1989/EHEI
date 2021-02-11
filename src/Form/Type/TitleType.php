<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TitleType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        // Define the choices for the TitleType
        $resolver->setDefaults([
            'choices' => [
                'MR.' => 'mr',
                'MRS.' => 'mrs',
                'MISS' => 'miss',
            ],
        ]);
    }

    /**
     * @return string|null The parent type
     */
    public function getParent()
    {
        return ChoiceType::class;
    }
}
