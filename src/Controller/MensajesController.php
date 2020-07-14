<?php

namespace App\Controller;

use App\Entity\Mensaje;
use App\Form\MensajeType;
use App\Entity\Comentario;
use App\Form\ComentarioType;
use App\Repository\MensajeRepository;
use App\Repository\ComentarioRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */
class MensajesController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/mensajes", name="mensajes")
     */
    public function index(MensajeRepository $repo)
    // Estaba escrito ComentarioRepository y por eso no se veian los mensajes en la pagina
    {
        return $this->render('mensajes/index.html.twig', [
            'mensajes' => $repo->findMensajeDesc()
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/mensajes/ajout", name="ajou_mensajes")
     */
    public function AjoutMesaje(Request $request)
    {
        //on cree un nouvelle OBJET (mensaje)
        $mensaje = new Mensaje();
       
        //on cree la variable form=formulaire Mensaje type créé avec la console
        $form = $this->createForm(MensajeType::class, $mensaje);
        //on prepare la recup du resultat du formulaire
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {

            $mensaje->setCreatedAt(new \DateTime());

            $em = $this->getDoctrine()->getManager();
            $em->persist($mensaje);
            $em->flush();

            $this->addFlash('success', 'perfecto gracias por tu mensaje');
            return $this->redirectToRoute('mensajes');
        }
        // on evoi dans la vue le form mensajeForm
        return $this->render('mensajes/AjoutMesaje.html.twig', [
            'formmesaje' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/mensajes/{id}", name="show_mensaje")
     */
    public function ShowMensaje(Mensaje $mensaje, Request $request)
    {

        // afficher et gerer le form Comentario
        $comentclient = new Comentario();

        $form = $this->createForm(ComentarioType::class, $comentclient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comentclient->setCreatedAt(new \DateTime());
            $comentclient->setMensaje($mensaje);
        
         
            // on recupere de quoi communiquer avec la BDD
            $em = $this->getDoctrine()->getManager();
            $em->persist($comentclient);
            $em->flush();

            $this->addFlash('success', 'merci pour votre commentaire');
            return $this->redirectToRoute('mensajes');
        }

        return $this->render('mensajes/ShowMesaje.html.twig', [
            'mensaje' => $mensaje,
            'FormComent' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/mensajes/{id}/delete", name="delete_mensaje")     * 
     */
    public function deleteMensaje(Mensaje $mensaje)
    {
        // on recupere de quoi communiquer avec la BDD
        $em = $this->getDoctrine()->getManager();
        // on recupere l'objet que ns allons suprimer
        $em->remove($mensaje);
        //pour valider l'enregistrement
        $em->flush();
    }
}
