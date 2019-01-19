<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\StudentEnrolledSubject;
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


        $roles = array("ROLE_ADMIN");
        $user = new User();
        $user->setFullname('Admin Admin');
        $user->setUsername('Admin');
        $user->setEmail('admin@mentorski.com');
        $user->setRoles($roles);
        $user->setStatus('None');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'password'
        ));

        $manager->persist($user);
        $manager->flush();
    }
}
