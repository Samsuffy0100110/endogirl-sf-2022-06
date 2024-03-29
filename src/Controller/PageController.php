<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/endometriose', name: 'endometriose')]
    public function index(): Response
    {
        return $this->render('page/endometriosis.html.twig');
    }

    #[Route('/legals', name: 'legals')]
    public function legals(): Response
    {
        return $this->render('page/legals.html.twig');
    }
}
