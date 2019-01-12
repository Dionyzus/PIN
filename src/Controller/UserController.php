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
use Symfony\Component\HttpFoundation\Session\Session;


class UserController extends AbstractController
{
    /**
     * @Route("/user/index",name="user_index")
     */
    public function index(Request $request,UserRepository $users)
    {

        $user=$users->findAll();
        return $this->render('user/index.html.twig',['users' => $user]);
    }
    /**
     * @Route("/user/edit", methods={"GET", "POST"}, name="user_edit")
     */
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'user.updated_successfully');

            return $this->redirectToRoute('user_edit');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'editForm' => $form->createView(),
        ]);
    }
    /**
     * Deletes a User entity.
     *
     * @Route("/userDelete/{id}", methods={"GET", "POST"}, name="user_delete")
     */
    public function delete(Request $request, User $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('homepage');
        }
        // Delete the tags associated with this blog post. This is done automatically
        // by Doctrine, except for SQLite (the database used in this application)
        // because foreign key support is not enabled by default in SQLite

        $em = $this->getDoctrine()->getManager();
        $user = $em -> getRepository(User::class)->find($id);
        $em -> remove($user);
        $em -> flush();

        $this->addFlash('success', 'user deleted successfully');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/user/editSubjects", methods={"GET", "POST"}, name="user_editSubjects")
     */
    public function editUserSubjects(Request $request): Response
    {
        $userId=$this->getUser();


        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);

        $studentEnrolledSubject=$doctrine->getRepository(StudentEnrolledSubject::class)->findSubjectsAssignedToUser($user);
        /*$subjects = array_map(function ($row) {
            return $row->getSubject();
        }, $subjects);*/

        return $this->render("user/showUsersSubjects.html.twig", [
            'user' => $user,
            'id'=>$userId,
            "subjects" => $studentEnrolledSubject,
        ]);
    }
    /**
     * @Route("{id<\d+>}/editStatus", methods={"GET", "POST"}, name="editStatus")
     */
    public function editStatus(Request $request,Subject $subjectId):Response
    {
        $user=$this->getUser();

        $studentEnrolledSubject = $this
            ->getDoctrine()
            ->getRepository(StudentEnrolledSubject::class)
            ->findOneBy(['user'=>$user,'subject'=>$subjectId])
        ;
        $form = $this->createForm(StudentSubjectType::class, $studentEnrolledSubject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'status.updated successfully');

            return $this->redirectToRoute('user_editSubjects');
        }

        return $this->render('user/changeStatus.html.twig', [
            'studentEnrolledSubject' => $studentEnrolledSubject,
            'form' => $form->createView(),
        ]);

    }

    /**
     * @Route("/user/change-password", methods={"GET", "POST"}, name="user_change_password")
     */
    public function changePassword(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
        $user = $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($encoder->encodePassword($user, $form->get('newPassword')->getData()));

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('security_logout');
        }

        return $this->render('user/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
