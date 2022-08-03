<?php

namespace App\Controller\Forum;

use DateTime;
use App\Service\Slugify;
use App\Entity\Forum\Reply;
use App\Entity\Forum\Topic;
use App\Entity\Forum\Subject;
use App\Form\Forum\ReplyType;
use App\Form\Forum\TopicType;
use App\Repository\Forum\ReplyRepository;
use App\Repository\Forum\TopicRepository;
use App\Repository\Forum\SubjectRepository;
use App\Repository\Forum\CategoryRepository;
use App\Repository\UserRepository;
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

    #[Route('/subject/{slug}', name: 'subject', requirements: ['slug' => '^[a-z0-9-]+$'], methods: ['GET', 'POST'])]
    public function subject(Request $request, Subject $subject, TopicRepository $topicRepository, Slugify $slugify, ReplyRepository $replyRepository): Response
    {
        $topic = $topicRepository->findBy(['subject' => $subject], ['createdAt' => 'DESC']);

        $topics = $topicRepository->createQueryBuilder('t')
            ->where('t.subject = :subject')
            ->setParameter('subject', $subject)
            ->orderBy('t.createdAt', 'DESC')
            ->getQuery()
            ->getResult();

            $replies = $replyRepository->findBy(['topic' => $topics], ['createdAt' => 'DESC']);

            $user = $this->getUser();
            $topic = new Topic();
            $topic->setCreatedAt(new DateTime());
            $topic->setSubject($subject);
            $topic->setUser($user);

            $form = $this->createForm(TopicType::class, $topic);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $slugify = new Slugify();
                $slug = $slugify->generate($topic->getTitle());
                $topic->setSlug($slug);
                $topicRepository->add($topic, true);


                return $this->redirectToRoute('forum_subject', ['slug' => $subject->getSlug()]);
            }
        return $this->render('forum/subject.html.twig', [
            'subject' => $subject,
            'topics' => $topics,
            'form' =>$form->createView(),
            'topic' => $topic,
            'replies' => $replies,
        ]);
    }

    #[Route('/topic/{slug}', name: 'topic', requirements: ['slug' => '^[a-z0-9-]+$'], defaults: ['slug' => 'default'], methods: ['GET', 'POST'])]
    public function topic(Request $request, Topic $topic, SubjectRepository $subjectRepository, ReplyRepository $replyRepository): Response
    {
        $reply = new Reply();
        $reply->setTopic($topic);
        $reply->setUser($this->getUser());
        $form = $this->createForm(ReplyType::class, $reply);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $replyRepository->add($reply, true);

            return $this->redirectToRoute('forum_topic', ['slug' => $topic->getSlug()]);
        }

        return $this->render('forum/topic.html.twig', [
            'topic' => $topic,
            'subject' => $subjectRepository->findOneBy(['slug' => $topic->getSubject()->getSlug()]),
            'form' => $form->createView(),
            'replies' => $replyRepository->findBy(['topic' => $topic]),
        ]);
    }
    
    #[Route('/reply/{id}', name: 'edit_reply', requirements: ['id' => '\d+'], methods: ['GET', 'POST'])]
    public function editReply(Request $request, ReplyRepository $replyRepository, TopicRepository $topicRepository): Response
    {
        $reply = $replyRepository->findOneBy(['id' => $request->get('id')]);
        $form = $this->createForm(ReplyType::class, $reply);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $replyRepository->add($reply, true);

            return $this->redirectToRoute('forum_topic', ['slug' => $reply->getTopic()->getSlug()]);
        }

        return $this->render('forum/edit_reply.html.twig', [
            'reply' => $reply,
            'form' => $form->createView(),
            'topic' => $topicRepository->findOneBy(['slug' => $reply->getTopic()->getSlug()]),
        ]);
    }

    #[Route('/reply/{id}/delete', name: 'delete_reply', methods: ['POST'])]
    public function deleteReply(Request $request, Reply $reply, ReplyRepository $replyRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reply->getId(), $request->request->get('_token'))) {
            $replyRepository->remove($reply, true);
        }

        return $this->redirectToRoute('forum_topic', ['slug' => $reply->getTopic()->getSlug()]);
    }
}
