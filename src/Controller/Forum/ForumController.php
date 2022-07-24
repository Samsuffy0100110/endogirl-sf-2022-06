<?php

namespace App\Controller\Forum;

use App\Repository\Forum\CategoryRepository;
use App\Repository\Forum\SubjectRepository;
use App\Repository\Forum\TopicRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/forum', name: 'forum_')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $category, SubjectRepository $subject, TopicRepository $topic): Response
    {
        return $this->render('forum/index.html.twig', [
            'categories' => $category->findAll(),
            'subjects' => $subject->findAll(),
            'topics' => $topic->findAll(),
        ]);
    }
}
