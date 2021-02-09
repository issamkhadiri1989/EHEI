<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /** @var Generator */
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create();
    }

    /**
     * Persisting data to the database.
     *
     * @param ObjectManager $manager the object manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadMainCategories($manager);
        $this->loadSubCategories($manager);
        $this->loadProducts($manager);
        $manager->flush();
    }

    /**
     * Loads samples of products.
     *
     * @param ObjectManager $manager the object manager
     */
    public function loadProducts(ObjectManager $manager)
    {
        //<editor-fold desc="Categories">

        /** @var Category $ladies */
        $ladies = $this->getReference('LADIES');
        /** @var Category $sunGlass */
        $sunGlass = $this->getReference('SUN_GLASS');

        //</editor-fold>

        $product = new Product();
        $product->setDesignation('Awesome Bags Collection')
            ->setUnitPrice(29.00)
            ->setImage('http://wpthemesgrid.com/themes/free/eshop/images/products/p6.jpg')
            ->setDescription($this->faker->paragraph(7))
            ->setCategory($ladies);
        $manager->persist($product);
        $product = new Product();
        $product->setDesignation('Black Sunglass For Women')
            ->setUnitPrice(50.00)
            ->setImage('http://wpthemesgrid.com/themes/free/eshop/images/products/p16.jpg')
            ->setDescription($this->faker->paragraph(3))
            ->setCategory($sunGlass);
        $manager->persist($product);
    }

    public function loadMainCategories(ObjectManager $manager)
    {
        $newArrivals = new Category();
        $newArrivals->setName('New Arrival');
        $manager->persist($newArrivals);
        $this->setReference('NEW_ARRIVAL', $newArrivals);
        $bestSelling = new Category();
        $bestSelling->setName('Best Selling');
        $manager->persist($bestSelling);
        $this->setReference('BEST_SELLING', $bestSelling);
        $watch = new Category();
        $watch->setName('Watch');
        $manager->persist($watch);
        $this->setReference('WATCH', $watch);
        $sunGlass = new Category();
        $sunGlass->setName('Sun Glass');
        $manager->persist($sunGlass);
        $this->setReference('SUN_GLASS', $sunGlass);
    }

    public function loadSubCategories(ObjectManager $manager)
    {
        /** @var Category $newArrivals */
        $newArrivals = $this->getReference('NEW_ARRIVAL');
        $ladies = new Category();
        $ladies->setName('Ladies')
            ->setCategory($newArrivals);
        $manager->persist($ladies);
        $this->addReference('LADIES', $ladies);

        $accessories = new Category();
        $accessories->setName('Accessories')
            ->setCategory($newArrivals);
        /** @var Category $bestSelling */
        $bestSelling = $this->getReference('BEST_SELLING');
        $kidsToys = new Category();
        $kidsToys->setName('Kids toys')
            ->setCategory($bestSelling);
        $this->addReference('KIDS_TOYS', $kidsToys);
    }
}
