<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use App\Entity\User;
use App\Entity\Article;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadData($manager);
        $manager->flush();
    }

    private function loadData(ObjectManager $manager)
    {
        $faker = Factory::create();
        $user1 = new User();
        $user1->setUsername('user1');
        $user1->setPassword($this->encoder->encodePassword($user1, '000000'));
        $manager->persist($user1);

        $user2 = new User();
        $user2->setUsername('user3');
        $user2->setPassword($this->encoder->encodePassword($user2, '000000'));
        $manager->persist($user2);

        $this->addReference('USER1', $user1);
        $this->addReference('USER2', $user2);

        $article1 = new Article();
        $article1->setTitle($faker->sentence(11))
            ->setAuthor($user1)
            ->setBody($faker->paragraph(14));
        $manager->persist($article1);

        $article2 = new Article();
        $article2->setTitle($faker->sentence(13))
            ->setAuthor($user2)
            ->setBody($faker->paragraph(35));
        $manager->persist($article2);
    }
}
