<?php

namespace App\DataFixtures;


use App\Entity\Subject;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class SubjectFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $subject = new Subject();
            $subject->setSubjectName('subject' . $i);
            $subject->setSubjectKey('key' . $i);
            $subject->setProgram('program'.$i);
            $subject->setEcts(6);
            $subject->setSemesterFullTimeStudent($i);
            $subject->setSemesterPartTimeStudent($i);
            $subject->setOptionalSubject('NE');
            $manager->persist($subject);
        }

        $manager->flush();
    }
}
