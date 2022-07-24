<?php

namespace App\Controller\Forum;

use App\Entity\Forum\Category;
use App\Repository\Forum\TopicRepository;
use App\Repository\Forum\SubjectRepository;
use App\Repository\Forum\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/forum', name: 'forum_')]
class ForumController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $category, SubjectRepository $subject, TopicRepository $topic): Response
    {
        $topics = $topic->findBy([], ['createdAt' => 'DESC']);
        $categories = $category->findAll();
        $subjects = $subject->findBy(['category' => $categories]);
        return $this->render('forum/index.html.twig', [
            'categories' => $categories,
            'subjects' => $subjects,
            'topics' => $topics,
        ]);
    }

    #[Route('/category/{slug}', name: 'category')]
    public function category(Category $category, SubjectRepository $subject, TopicRepository $topic): Response
    {
        $topics = $topic->findBy(['category' => $category]);
        $subjects = $subject->findBy(['category' => $category]);
        $topics = $topic->findBy(['subject' => $subjects]);
        return $this->render('forum/category.html.twig', [
            'category' => $category,
            'subjects' => $subjects,
            'topics' => $topics,
        ]);
    }
}
