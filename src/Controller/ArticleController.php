<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ArticleController extends AbstractController
{
    #[Route('/article/{id}', name: 'article_show', requirements: ['id' => '\d+'])]
    public function index(int $id, EntityManagerInterface $em): Response
    {
        $article = $em->getRepository(Article::class)->find($id);

        return $this->render('article/index.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/add', name: 'article_add')]
    #[Route('/article/edit/{id}', name: 'article_edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, EntityManagerInterface $em, int $id = null): Response
{
    if ($id) {
        $mode = 'update';
        $article = $em->getRepository(Article::class)->find($id);

        if (!$article || $article->getAuthor() !== $this->getUser()) {
            throw $this->createAccessDeniedException("Vous ne pouvez modifier que vos articles.");
        }
    } else {
        $mode = 'new';
        $article = new Article();
        $article->setAuthor($this->getUser());
    }

    $form = $this->createForm(ArticleType::class, $article);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        if ($article->isPublished()) {
            $article->setPublishedAt(new \DateTime());
        }

        $em->persist($article);
        $em->flush();

        $this->addFlash('success', 'Article enregistré avec succès.');
        return $this->redirectToRoute('app_home');
    }

    return $this->render('article/edit.html.twig', [
        'form' => $form->createView(),
        'article' => $article,
        'mode' => $mode,
    ]);
}
  #[Route('/article/remove/{id}', name: 'article_remove', requirements: ['id' => '\d+'])]
public function remove(int $id, EntityManagerInterface $em): Response
{
    $article = $em->getRepository(Article::class)->find($id);

    if (!$article || $article->getAuthor() !== $this->getUser()) {
        throw $this->createAccessDeniedException("Vous ne pouvez supprimer que vos articles.");
    }

    $em->remove($article);
    $em->flush();

    $this->addFlash('success', 'Article supprimé avec succès.');
    return $this->redirectToRoute('app_home');
}

}
 