<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\LinksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $article = $articleRepository->findOneBy(['isPublished' => true], ['createdAt' => 'DESC'], 1);
        return $this->render('home/index.html.twig', [
            'article' => $article,
        ]);
    }

    public function showLinks(LinksRepository $linksRepository): Response
    {
        $links = $linksRepository->findAll();
        return $this->render('include/_links.html.twig', [
            'links' => $links,
        ]);
    }   
}
