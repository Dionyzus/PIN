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

use Symfony\Component\Intl\Exception\NotImplementedException;
use App\Form\Type\ChangePasswordType;
use App\Form\StudentSubjectType;
use App\Entity\StudentEnrolledSubject;
use App\Form\UserType;
use App\Form\SubjectType;
use App\Form\UserEditType;
use App\Repository\StudentEnrolledSubjectRepository;
use App\Entity\User;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
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
        $userId=$this->getUser();
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(StudentEnrolledSubject::class);

        $user = $doctrine->getRepository(User::class)->find($userId);

        $subjects = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->findAll()
        ;

        $assignedSubjects = $repository->findSubjectsAssignedToUser($user);


        $assignedSubjects = array_map(function ($row) {
            return $row->getSubject();
        }, $assignedSubjects);
        $result = array_diff($subjects, $assignedSubjects);


        return $this->render("user/enroll.html.twig", [
                'user' => $user,
                'id'=>$userId,
                "assignedSubjects" => $assignedSubjects,
                "unassignedSubjects" => $result,
            ]
        );
    }
    /**
     * @Route("/{userId}/enrollSubject/{subjectId}", name="student.enroll")
     */
    public function studentEnroll($userId, $subjectId)
    {
        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);
        $subject = $doctrine->getRepository(Subject::class)->find($subjectId);

        $studentEnrolledSubject = new StudentEnrolledSubject();

        $studentEnrolledSubject
            ->setUser($user)
            ->setSubject($subject)
            ->setStatus('Enrolled')
        ;

        $em = $doctrine->getManager();
        $em->persist($studentEnrolledSubject);
        $em->flush();

        return $this->redirectToRoute('user_editSubjects', ['userId' => $userId]);
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
    /**
     * @Route("/admin/{userId}", name="admin.index")
     */
    public function index($userId)
    {
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(StudentEnrolledSubject::class);

        $user = $doctrine->getRepository(User::class)->find($userId);

        $subjects = $this
            ->getDoctrine()
            ->getRepository(Subject::class)
            ->findAll()
        ;

        $assignedSubjects = $repository->findSubjectsAssignedToUser($user);


        $assignedSubjects = array_map(function ($row) {
            return $row->getSubject();
        }, $assignedSubjects);
        $result = array_diff($subjects, $assignedSubjects);


        return $this->render("admin/index.html.twig", [
            'user' => $user,
            'id'=>$userId,
            "assignedSubjects" => $assignedSubjects,
            "unassignedSubjects" => $result,
            ]
        );
    }

    /**
     * @Route("/{userId}/assign/{subjectId}", name="admin.assign")
     */
    public function assign($userId, $subjectId)
    {
        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);
        $subject = $doctrine->getRepository(Subject::class)->find($subjectId);

        $studentEnrolledSubject = new StudentEnrolledSubject();

        $studentEnrolledSubject
            ->setUser($user)
            ->setSubject($subject)
            ->setStatus('Enrolled')
        ;

        $em = $doctrine->getManager();
        $em->persist($studentEnrolledSubject);
        $em->flush();

        return $this->redirectToRoute('admin.index', ['userId' => $userId]);
    }
    /**
     * @Route("/{userId}/unassign/{subjectId}", name="admin.unassign")
     */
    public function unassign($userId, $subjectId)
    {
        $doctrine = $this->getDoctrine();
        $user = $doctrine->getRepository(User::class)->find($userId);
        $subject = $doctrine->getRepository(Subject::class)->find($subjectId);

        $studentEnrolledSubject=$doctrine->getRepository(StudentEnrolledSubject::class)->findOneBy(['user'=>$userId,'subject'=>$subjectId]);
        $user->removeStudentSubject($studentEnrolledSubject);

        $em = $doctrine->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin.index', ['userId' => $userId]);
    }
}
