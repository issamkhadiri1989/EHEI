<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class ProductType extends AbstractType
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Product title',
            ])
            ->add('shortDescription', TextType::class, [
                'label' => 'Product short description',
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Content',
                'required' => false,
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('coverImage', TextType::class, [
                'label' => 'Product cover',
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
            ])
            ->add('featured', ChoiceType::class, [
                /*'expanded' => true,*/
                'choices' => [
                    'Show this product as FEATURED' => true,
                    'This product is not featured' => false,
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'category',
                'placeholder' => 'Choose category',
                'choice_value' => 'slug',
                /*'query_builder' => function (CategoryRepository $repository) {
                    $user = $this->security->getUser();

                    return $repository
                        ->createQueryBuilder('c')
                        ->orderBy('c.category', 'asc');
                }*/
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                dump('FormEvents::PRE_SET_DATA');
                dump($event->getData());
            })
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                dump('FormEvents::POST_SET_DATA');
                dump($event->getData());
            })
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
                dump('FormEvents::PRE_SUBMIT');
                $data = $event->getData();
                dump($event->getData());
                $form = $event->getForm();
                if (!empty($data['foo'])) {
                    /** @var Product $product */
                    $product = $form->getData();
                    $product->setAddress($data['foo']['address']);
                    $product->setCity($data['foo']['city']);
                    $product->setState($data['foo']['state']);
                    $product->setZipCode($data['foo']['zipCode']);
                    $form->setData($product);
                }
            })
            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
                dump('FormEvents::SUBMIT');
                dump($event->getData());
            })
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                dump('FormEvents::POST_SUBMIT');
                dump($event->getData());

                /** @var Product $data */
                $data = $event->getData();
                $form = $event->getForm();
                if ($data->getPrice() === 0) {
                    $form->remove('foo');
                }
            });
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['slug'] = $options['slug'] ?? '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
            'label' => false,
            'allow_extra_fields' => true,
            'slug' => '',
        ]);
        $resolver->setAllowedTypes('slug', 'string');
    }
}