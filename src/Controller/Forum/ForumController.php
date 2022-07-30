<?php

namespace App\Controller\Forum;

use App\Entity\Forum\Topic;
use App\Entity\Forum\Subject;
use App\Form\Forum\TopicType;
use App\Repository\Forum\TopicRepository;
use App\Repository\Forum\SubjectRepository;
use App\Repository\Forum\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/subject/{slug}', name: 'subject', methods: ['GET', 'POST'], requirements: ['slug' => '^[a-z0-9-]+$'])]
    public function subject(Request $request, Subject $subject, TopicRepository $topicRepository): Response
    {
        $topics = $topicRepository->createQueryBuilder('t')
            ->where('t.subject = :subject')
            ->setParameter('subject', $subject)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

            $user = $this->getUser();
            $topic = new Topic();
            $topic->setCreatedAt(new \DateTime());
            $topic->setSubject($subject);
            $topic->setUser($user);
            $form = $this->createForm(TopicType::class, $topic);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $topicRepository->add($topic, true);

                return $this->redirectToRoute('forum_subject', ['slug' => $subject->getSlug()]);
            }
            
        return $this->render('forum/subject.html.twig', [
            'subject' => $subject,
            'topics' => $topics,
            'form' =>$form->createView(),
        ]);
    }

}
