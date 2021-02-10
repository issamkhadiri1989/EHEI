<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    /**
     * Loads some dummy samples.
     *
     * @param ObjectManager $manager The  entity manager
     */
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('HOSLEY - Set of 7 Purple Lavender Fields Scented Jar Candle With Tealights')
            ->setQuantity(4)
            ->setBarcode('10820594');
        $manager->persist($product);

        $product = new Product();
        $product->setName('ZANIBO - White & Gold-Toned Floral Solid Analogue Wall Clock')
            ->setQuantity(3)
            ->setBarcode('11133134');
        $manager->persist($product);

        $manager->flush();
    }
}
