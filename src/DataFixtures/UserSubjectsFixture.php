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
        $subject = new Subject();
        $subject->setSubjectName('subject');
        $subject->setSubjectKey('key');
        $subject->setProgram('program');
        $subject->setEcts(6);
        $subject->setSemesterFullTimeStudent(5);
        $subject->setSemesterPartTimeStudent(6);
        $subject->setOptionalSubject('NO');

        $subject1 = new Subject();
        $subject1->setSubjectName('subject1');
        $subject1->setSubjectKey('key1');
        $subject1->setProgram('program1');
        $subject1->setEcts(6);
        $subject1->setSemesterFullTimeStudent(5);
        $subject1->setSemesterPartTimeStudent(6);
        $subject1->setOptionalSubject('NO');

        $studentEnrolledSubject = new StudentEnrolledSubject();
        $studentEnrolledSubject1 = new StudentEnrolledSubject();
        $studentEnrolledSubject2 = new StudentEnrolledSubject();

        $roles = array("ROLE_USER","ROLE_ADMIN");
        $user = new User();
        $user->setFullname('fullname1');
        $user->setUsername('user');
        $user->setEmail('mail');
        $user->setRoles($roles);
        $user->setStatus('Full time student');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user, 'password'
        ));
        $user1 = new User();
        $user1->setFullname('fullname2');
        $user1->setUsername('user1');
        $user1->setEmail('mail1');
        $user1->setRoles($roles);
        $user1->setStatus('Full time student');
        $user1->setPassword($this->passwordEncoder->encodePassword(
            $user1, 'password'
        ));
        $studentEnrolledSubject->setUser($user);
        $studentEnrolledSubject->setSubject($subject);
        $studentEnrolledSubject->setStatus("passed");

        $studentEnrolledSubject1->setUser($user1);
        $studentEnrolledSubject1->setSubject($subject);
        $studentEnrolledSubject1->setStatus("passed");

        $studentEnrolledSubject2->setUser($user);
        $studentEnrolledSubject2->setSubject($subject1);
        $studentEnrolledSubject2->setStatus("notPassed");


        $manager->persist($user);
        $manager->persist($user1);
        $manager->persist($subject);
        $manager->persist($subject1);
        $manager->persist($studentEnrolledSubject);
        $manager->persist($studentEnrolledSubject1);
        $manager->persist($studentEnrolledSubject2);
        $manager->flush();
    }
}
