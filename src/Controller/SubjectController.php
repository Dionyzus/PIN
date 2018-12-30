<?php
namespace App\Controller;

use App\Form\SubjectType;
use App\Entity\Subject;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\SubjectRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SubjectController extends AbstractController
{
    /**
     * Creates a new Post entity.
     *
     * @Route("/subject/newSubject", methods={"GET", "POST"}, name="subject_new")
     *
     * NOTE: the Method annotation is optional, but it's a recommended practice
     * to constraint the HTTP methods each controller responds to (by default
     * it responds to all methods).
     */
    public function new(Request $request): Response
    {
        $subject = new Subject();
        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(SubjectType::class, $subject)
            ->add('saveAndCreateNew', SubmitType::class);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($subject);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', 'subject created successfully');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute('subject_new');
            }

            return $this->redirectToRoute('subject_index');
        }

        return $this->render('user/addSubject.html.twig', [
            'subject' => $subject,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Finds and displays a Post entity.
     *
     * @Route("/{id<\d+>}", methods={"GET"}, name="subject_show")
     */
    public function show(Subject $subject): Response
    {
        // This security check can also be performed
        // using an annotation: @IsGranted("show", subject="post", message="Posts can only be shown to their authors.")
        //$this->denyAccessUnlessGranted('show', $subject, 'Posts can only be shown to their authors.');

        return $this->render('user/showSubject.html.twig', [
            'subject' => $subject,
        ]);
    }

    /**
     * Displays a form to edit an existing Subject entity.
     *
     * @Route("/{id<\d+>}/edit",methods={"GET", "POST"}, name="subject_edit")
     */
    public function edit(Request $request, Subject $subject): Response
    {
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'All fields should be filled!');

            return $this->redirectToRoute('subject_edit', ['id' => $subject->getId()]);
        }

        return $this->render('user/editSubject.html.twig', [
            'subject' => $subject,
            'form' => $form->createView(),
        ]);
    }
    /**
     * Deletes a Subject entity.
     *
     * @Route("/{id}/delete", methods={"GET", "POST"}, name="subject_delete")
     */
    public function delete(Request $request, Subject $subject): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('homepage');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($subject);
        $em->flush();

        $this->addFlash('success', 'subject deleted successfully');

        return $this->redirectToRoute('subject_index');
    }

    /**
     * @Route("/subject/index",name="subject_index")
     */
    public function index(Request $request,SubjectRepository $subjects)
    {

        $subject=$subjects->findAll();
        return $this->render('subject/index.html.twig',['subjects' => $subject]);
    }

    /**
     * @Route("/subject/find/{ects}")
     */
    public function findSubject($ects)
    {
        $subject=$this->getDoctrine()
            ->getRepository(Subject::class)
            ->findByEcts($ects);

        return $this->render('subject/show.html.twig', ['subject' => $ects]);
    }

}