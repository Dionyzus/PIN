<?php


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
     * @Route("/app/user/index",name="user_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request,UserRepository $users)
    {
        $userId=$this->getUser();
        $user=$users->findAll();
        return $this->render('user/index.html.twig',['users' => $user,'id'=>$userId]);
    }
    /**
     * @Route("/app/user/edit", methods={"GET", "POST"}, name="user_edit")
     * @IsGranted("ROLE_USER")
     */
    public function editUser(Request $request): Response
    {
        $user = $this->getUser();
        $user->getPassword();

        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Data updated successfully!');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'editForm' => $form->createView(),
        ]);
    }
    /**
     * Deletes a User entity.
     * @Route("/userDelete/{id}", methods={"GET", "POST"}, name="user_delete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, User $id): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('homepage');
        }


        $em = $this->getDoctrine()->getManager();
        $user = $em -> getRepository(User::class)->find($id);
        $em -> remove($user);
        $em -> flush();

        $this->addFlash('success', 'user deleted successfully');
        return $this->redirectToRoute('user_index');
    }

    /**
     * @Route("/app/user/editSubjects", methods={"GET", "POST"}, name="user_editSubjects")
     * @IsGranted("ROLE_USER")
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
     * @IsGranted("ROLE_USER")
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
     * @Route("/app/user/change-password", methods={"GET", "POST"}, name="user_change_password")
     * @IsGranted("ROLE_USER")
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
