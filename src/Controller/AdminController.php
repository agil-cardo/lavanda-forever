<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 * si l'on mets pas "" le message d'erreur ne sera jamais assez explicite pour le trouver Be carefull
 */
class AdminController extends AbstractController
{
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/ajouArticle", name="ajouArticle")
     */
    public function ajoutArticle(Request $request, EntityManagerInterface $em)
    {
        //on cree un nouvelle OBJET (article)
        $article = new Article();

        //on cree la variable form=formulaire Article type créé avec la console
        $form = $this->createForm(ArticleType::class, $article);
        //on prepare la recup du resultat du formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //on prepare l'enregistrement de l'Objet Article rempli 
            $em->persist($article);
            //on execute on enregistre sur la DBB
            $em->flush();

            //on envoi un message de requet bien executée cordialement SAR G Corporation
            $this->addFlash('success', 'article bien enregistré et mis en ligne, cordialement, devs team');
            //on renvoi vers la route article pour eviter la reptition d'envoi du form
            return $this->redirectToRoute('article');
        }

        // on evoi dans la vue le form articleForm
        return $this->render('admin/ajouArticle.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route ("/admin/article/{id}/delete", name="deleteArticle")
     */
    public function deleteArticle(Article $article) {

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('success', 'l\'article a bien été supprimé');
        return $this->redirectToRoute('article');

    }
   
}
