<?php

namespace App\Controller\Admin;

use App\Entity\Links;
use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Forum\Category;
use App\Entity\Forum\Subject;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Endoloris - Administration')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Articles', 'fas fa-list', Article::class);
        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Liens utiles', 'fas fa-list', Links::class);
        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list', Comment::class);
        yield MenuItem::section('Forum');
        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Catégories', 'fas fa-list', Category::class);
        yield MenuItem::section('');
        yield MenuItem::linkToCrud('Sujets', 'fas fa-list', Subject::class);
        yield MenuItem::section('');
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'home');
        
    }
}
