<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\StudentEnrolledSubject;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubjectsFixture extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

    }
}
