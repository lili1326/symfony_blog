<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'app_article', requirements: ['id' => '\\d+'])]
    public function index(EntityManagerInterface $em, int $id): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/add', name: 'article_add')]
    #[Route('/edit/{id}', name: 'article_edit', requirements: ['id' => '\\d+'])]
    public function edit(Request $request, EntityManagerInterface $em, int $id = null): Response
    {
        if ($id) {
            $mode = 'update';
            $article = $em->getRepository(Article::class)->find($id);
        } else {
            $mode = 'new';
            $article = new Article();
        }

        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->saveArticle($article, $mode, $em);
            return $this->redirectToRoute('app_home');
        }

        return $this->render('article/edit.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'mode' => $mode,
        ]);
    }

    #[Route('/remove/{id}', name: 'article_remove', requirements: ['id' => '\\d+'])]
    public function remove(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    private function completeArticleBeforeSave(Article $article, string $mode): Article
    {
        if ($article->isPublished() && !$article->getPublishedAt()) {
            $article->setPublishedAt(new \DateTime());
        }

        $user = $this->getUser();
        if (!$user) {
            throw $this->createAccessDeniedException('Vous devez être connecté pour enregistrer un article.');
        }

        $article->setAuthor($user);
        return $article;
    }

    private function saveArticle(Article $article, string $mode, EntityManagerInterface $em): void
    {
        $article = $this->completeArticleBeforeSave($article, $mode);
        $em->persist($article);
        $em->flush();
        $this->addFlash('success', 'Enregistré avec succès');
    }
}
 