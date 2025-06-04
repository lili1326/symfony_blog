<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository): Response
    {
        // Affiche tous les articles publiés
        $articles = $articleRepository->findBy(['isPublished' => true]);

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
 