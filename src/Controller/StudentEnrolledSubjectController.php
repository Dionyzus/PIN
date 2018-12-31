<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Form\EnrollSubjectType;
use App\Form\StudentSubjectType;
use App\Entity\StudentEnrolledSubject;
use App\Form\UserType;
use App\Form\SubjectType;
use App\Form\UserEditType;
use App\Entity\User;
use App\Entity\Subject;
use App\Repository\StudentEnrolledSubjectRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Doctrine\ORM\EntityRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class StudentEnrolledSubjectController extends AbstractController
{
    /**
     * @Route("/user/enrollSubject", methods={"GET", "POST"}, name="enroll_subject")
     */
    public function enrollSubject(Request $request): Response
    {
        $user=$this->getUser();
        $studentEnrolledSubject= new StudentEnrolledSubject();

        $form = $this->createForm(StudentSubjectType::class)
            ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentEnrolledSubject->setUser($user);
            $studentEnrolledSubject->setSubject($form->get('subject')->getData());
            $studentEnrolledSubject->setStatus($form->get('status')->getData());

            $em = $this->getDoctrine()->getManager();
            $em->persist($studentEnrolledSubject);
            $em->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('enroll_subject');
            }


            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/enroll.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/user/showSubjects",name="show_subjects")
     */
    public function showSubjects(Request $request,StudentEnrolledSubjectRepository $stusEnrolSubjects)
    {
        $stuEnrolSubject=$stusEnrolSubjects->findAll();
        return $this->render('user/showUserSubjects.html.twig',['stusEnrolSubjects'=>$stuEnrolSubject]);
    }
    /**
     * Displays a form to edit an existing Subject entity.
     *
     * @Route("/{id}/subEdit",methods={"GET", "POST"}, name="user_subject_edit")
     */
    public function edit(Request $request, StudentEnrolledSubject $studentEnrolledSubject): Response
    {
        $form = $this->createForm(StudentSubjectType::class, $studentEnrolledSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_subject_edit', ['id' => $studentEnrolledSubject->getId()]);
        }

        return $this->render('user/showUsersSubjects.html.twig', [
            'studentEnrolledSubject' => $studentEnrolledSubject,
            'form' => $form->createView(),
        ]);
    }
}
