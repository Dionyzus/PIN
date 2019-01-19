<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\StudentEnrolledSubject;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SubjectFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $subject = new Subject();
        $subject->setSubjectName('Programiranje na internetu');
        $subject->setSubjectKey('P01');
        $subject->setProgram('Programiranje');
        $subject->setEcts(6);
        $subject->setSemesterFullTimeStudent(5);
        $subject->setSemesterPartTimeStudent(6);
        $subject->setOptionalSubject('NO');

        $subject1 = new Subject();
        $subject1->setSubjectName('Programiranje u javi');
        $subject1->setSubjectKey('P02');
        $subject1->setProgram('Programiranje');
        $subject1->setEcts(6);
        $subject1->setSemesterFullTimeStudent(5);
        $subject1->setSemesterPartTimeStudent(6);
        $subject1->setOptionalSubject('NO');

        $subject2 = new Subject();
        $subject2->setSubjectName('Programski alati za UNIX');
        $subject2->setSubjectKey('P03');
        $subject2->setProgram('Računalne mreže');
        $subject2->setEcts(6);
        $subject2->setSemesterFullTimeStudent(5);
        $subject2->setSemesterPartTimeStudent(6);
        $subject2->setOptionalSubject('YES');

        $subject3 = new Subject();
        $subject3->setSubjectName('Objektno orijetnirano modeliranje');
        $subject3->setSubjectKey('P04');
        $subject3->setProgram('Baze podataka');
        $subject3->setEcts(6);
        $subject3->setSemesterFullTimeStudent(5);
        $subject3->setSemesterPartTimeStudent(6);
        $subject3->setOptionalSubject('YES');

        $subject4 = new Subject();
        $subject4->setSubjectName('Diskretna matematika');
        $subject4->setSubjectKey('P05');
        $subject4->setProgram('IT program');
        $subject4->setEcts(6);
        $subject4->setSemesterFullTimeStudent(4);
        $subject4->setSemesterPartTimeStudent(6);
        $subject4->setOptionalSubject('NO');

        $subject5 = new Subject();
        $subject5->setSubjectName('Programiranje u C#');
        $subject5->setSubjectKey('P06');
        $subject5->setProgram('Programiranje');
        $subject5->setEcts(6);
        $subject5->setSemesterFullTimeStudent(5);
        $subject5->setSemesterPartTimeStudent(6);
        $subject5->setOptionalSubject('YES');

        $subject6 = new Subject();
        $subject6->setSubjectName('Sigurnost računala i podataka');
        $subject6->setSubjectKey('P07');
        $subject6->setProgram('Računalne mreže');
        $subject6->setEcts(6);
        $subject6->setSemesterFullTimeStudent(5);
        $subject6->setSemesterPartTimeStudent(6);
        $subject6->setOptionalSubject('YES');

        $manager->persist($subject);
        $manager->persist($subject1);
        $manager->persist($subject2);
        $manager->persist($subject3);
        $manager->persist($subject4);
        $manager->persist($subject5);
        $manager->persist($subject6);

        $manager->flush();
    }
}
