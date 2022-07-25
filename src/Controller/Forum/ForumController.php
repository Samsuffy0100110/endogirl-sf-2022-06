<?php

namespace App\Controller\Forum;

use App\Entity\Forum\Subject;
use App\Entity\Forum\Category;
use App\Repository\Forum\TopicRepository;
use App\Repository\Forum\SubjectRepository;
use App\Repository\Forum\CategoryRepository;
use App\Service\Slugify;
use Doctrine\ORM\Mapping\Id;
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

    #[Route('/subject/{slug}', name: 'subject', methods: ['GET'], requirements: ['slug' => '^[a-z0-9-]+$'])]
    public function subject(Subject $subject, TopicRepository $topicRepository): Response
    {
        $topics = $topicRepository->createQueryBuilder('t')
            ->where('t.subject = :subject')
            ->setParameter('subject', $subject)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
            
        return $this->render('forum/subject.html.twig', [
            'subject' => $subject,
            'topics' => $topics,
        ]);
    }
}
