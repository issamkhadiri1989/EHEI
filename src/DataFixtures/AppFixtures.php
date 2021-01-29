<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    # src/DataFixtures/AppFixtures.php

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
        $admin = new User();
        $admin->setFirstName('Issam')
            ->setLastName('Khadiri')
            ->setEmail('issam@ehei.com')
            ->setHash($this->encoder->encodePassword($admin, '000000'))
            ->addUserRole((new Role())->setLabel('ROLE_ADMIN'))
            ;

        $manager->persist($admin);
        //...The rest of the fixture




        $user = new User();
        $encrypted = $this->encoder
            ->encodePassword($user, 'myPassword');

        $user->setFirstName('Sandy')
            ->setLastName('Olle')
            ->setEmail('solle0@uol.com.br')
            ->setHash($encrypted);




        $manager->persist($user);

        $manager->flush();
    }
}
