<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Form\ComentarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactaNosController extends AbstractController
{
    /**
     * @Route("/contacta/nos", name="contacta_nos")
     */
    public function ContactaNos(Request $request, EntityManagerInterface $em)
    {
        $comentclient = new Contact();

        $form = $this->createForm(ContactType::class, $comentclient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comentclient->setCreatedAt(new \DateTime());

            $em->persist($comentclient);
            $em->flush();

            $this->addFlash('success', 'merci pour votre message');
            return $this->redirectToRoute('mensajes');
        }

        return $this->render('contacta_nos/index.html.twig', [
            'FormContact' => $form->createView(),
        ]);
    }
}
