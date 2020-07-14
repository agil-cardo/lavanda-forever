<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
     /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("/Qui-sommes-nous", name="qui_page")
     */
    public function quiSommesNous()
    {
        return $this->render('main/quiPage.html.twig');
    }
}
