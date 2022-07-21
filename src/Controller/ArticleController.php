<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/article', name: 'article_')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/{id<^[0-9]+$>}', name: 'show')]
    public function show(
        int $id,
        ArticleRepository $articleRepository,
        Request $request,
        CommentRepository $commentRepository
        ): Response {
        $article = $articleRepository->find($id);
        $comment = new Comment();
        $comment->setArticle($article);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $commentRepository->add($comment, true);

            $this->addFlash('success', 'Merci pour ton commentaire !');

            return $this->redirectToRoute('article_show', ['id' => $id]);
        }
        
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
        ]);
    }
}
