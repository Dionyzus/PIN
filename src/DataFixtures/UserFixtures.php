<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setEmail('mail' . $i);
            $user->setRoles('ROLE_ADMIN');
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user, 'password'
            ));
            $manager->persist($user);
        }

        $manager->flush();
    }
}

