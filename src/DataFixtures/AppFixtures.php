<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    /**
     * @var \Faker\Generator
     */
    private $faker;

    const CATEGORIES = 3;

    const PRODUCTS = 15;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Load dummy data.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= self::CATEGORIES; $i++) {
            $category = new Category();
            $category->setCategory($this->faker->name());
            $manager->persist($category);
            $this->addReference('CAT'.$i, $category);
        }

        for ($i = 1; $i <= self::PRODUCTS; $i++) {
            $product  = new Product();
            /** @var Category $category */
            $category = $this->getReference('CAT'.\rand(1, self::CATEGORIES));
            $product->setCategory($category)
                ->setVote(\rand(1, 5))
                ->setTitle($this->faker->sentence)
                ->setPrice($this->faker->randomFloat(2, 1000, 25000))
                ->setShortDescription($this->faker->paragraph())
                ->setContent(\sprintf(
                    '<p>%s</p>',
                    \implode('</p><p>', $this->faker->paragraphs(10))
                ))
                ->setCoverImage(\sprintf(
                    'https://picsum.photos/200/300?random=%d',
                    \rand(1, 99999)
                ));
            $manager->persist($product);
            $this->addReference('PROD'.$i, $product);
        }

        /** @var Product $featuredProduct */
        $featuredProduct = $this->getReference('PROD'.\rand(1, self::PRODUCTS - 1));
        $featuredProduct->setFeatured(true);
        $manager->flush();
    }
}
