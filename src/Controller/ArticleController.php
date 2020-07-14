<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/article", name="article")
     */
    public function index(ArticleRepository $repository)
    {
        // d'abord tout les articles et apres un article avec la méthode render qui est dans AbstractController
            return $this->render('article/index.html.twig', [
            'articles' => $repository->findAll(),
        ]);
    }

    /**
     * @Route ("/article/{id}", name="showArticle")
     */
    public function ShowArticle(Article $article)
    {
        // Dans le fichier showArticle.html.tiw on utilise article.title
        // Pour afficher le titre 
        return $this->render('article/showArticle.html.twig', [
            'article' => $article,
        ]);
    }

}
