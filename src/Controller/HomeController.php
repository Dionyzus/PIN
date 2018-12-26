<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{
    /**
     * @Route("/index", name="app_index")
     */
    public function welcome()
    {
        return $this->render('index.html.twig',[
            "welcome",
        ]);
    }
}