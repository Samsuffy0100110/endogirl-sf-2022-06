<?php

namespace App\Controller\Forum;

use App\Entity\Forum\Topic;
use App\Form\Forum\TopicType;
use App\Repository\Forum\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forum/topic')]
class TopicController extends AbstractController
{
    #[Route('/', name: 'forum_topic_index', methods: ['GET'])]
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render('forum/topic/index.html.twig', [
            'topics' => $topicRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'forum_topic_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TopicRepository $topicRepository): Response
    {
        $user = $this->getUser();
        $topic = new Topic();
        $topic->setCreatedAt(new \DateTime());
        $topic->setUser($user);
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topicRepository->add($topic, true);

            return $this->redirectToRoute('forum_topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('forum/_form_topic.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'forum_topic_show', methods: ['GET'])]
    public function show(Topic $topic): Response
    {
        return $this->render('forum/topic/show.html.twig', [
            'topic' => $topic,
        ]);
    }

    #[Route('/{id}/edit', name: 'forum_topic_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Topic $topic, TopicRepository $topicRepository): Response
    {
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $topicRepository->add($topic, true);

            return $this->redirectToRoute('forum_topic_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('forum/topic/edit.html.twig', [
            'topic' => $topic,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'forum_topic_delete', methods: ['POST'])]
    public function delete(Request $request, Topic $topic, TopicRepository $topicRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$topic->getId(), $request->request->get('_token'))) {
            $topicRepository->remove($topic, true);
        }

        return $this->redirectToRoute('forum_topic_index', [], Response::HTTP_SEE_OTHER);
    }
}
