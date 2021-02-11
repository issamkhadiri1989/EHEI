<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\Type\TitleType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TitleType::class)
            // ...
        ;
    }
    //...
}