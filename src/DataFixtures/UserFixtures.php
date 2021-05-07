<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('khadiri.issam@gmail.com')
            ->setPassword($this->encoder->encodePassword($user, '1234'))
            ->setRoles(['ROLE_USER']);
        $manager->persist($user);
        $admin = new User();
        $admin->setEmail('admin@user.com')
            ->setPassword($this->encoder->encodePassword($admin, '0000'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}
