<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Country;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $morocco = (new Country())
            ->setName('Morocco')
            ->setCode('MAR')
            ->addCity((new City())->setName('Oujda'))
            ->addCity((new City())->setName('Casablanca'));
        $manager->persist($morocco);
        $canada = (new Country())
            ->setName('Canada')
            ->setCode('CAN')
            ->addCity((new City())->setName('Montreal'));
        $manager->persist($canada);
        $manager->flush();
    }
}
