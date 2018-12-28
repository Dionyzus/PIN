<?php
namespace App\Controller;

use App\Form\SubjectType;
use App\Entity\Subject;
use App\Repository\SubjectRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SubjectController extends AbstractController
{
    /**
     * @Route("/subject", name="create_subject")
     */
    public function createSubject(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $subject = new Subject();
        $form = $this->createForm(SubjectType::class, $subject);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 4) save the Subject!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subject);
            $entityManager->flush();


            return $this->redirectToRoute('app_index');
        }

        return $this->render(
            'subject/subject.html.twig',
            array('form' => $form->createView())
        );
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
     * @Route("/subject/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $subject = $entityManager->getRepository(subject::class)->find($id);

        if (!$subject) {
            throw $this->createNotFoundException(
                'No subject found for id '.$id
            );
        }

        $subject->setSubjectName('New subject name!');
        $entityManager->flush();

        return $this->redirectToRoute('subject_show', [
            'id' => $subject->getId()
        ]);
    }
    /**
     * @Route("/subject/delete/{id}")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $subject = $entityManager->getRepository(subject::class)->find($id);

        if (!$subject) {
            throw $this->createNotFoundException(
                'No subject found for id '.$id
            );
        }

        $subject->remove($subject);
        $entityManager->flush();

        return $this->redirectToRoute('subject_show', [
            'id' => $subject->getId()
        ]);
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