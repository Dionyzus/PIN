<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class AdminController extends AbstractController
{
    /**
     * @Route("/app/index", name="app_index")
     * @IsGranted("ROLE_USER")
     */
    public function AppIndex(Request $request)
    {
        $userId=$this->getUser();


        $doctrine = $this->getDoctrine();

        $user = $doctrine->getRepository(User::class)->find($userId);

        return $this->render("default/appIndex.html.twig", [
            'user' => $user,
        ]);
    }
}
