<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request): Response
    {
        // Crée un formulaire en utilisant la classe ContactType
        $form = $this->createForm(ContactType::class);
        // gère la demande et vérifie si le formulaire a été soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ajoute un message flash pour informer l'utilisateur que le message a été envoyé
                $this->addFlash('success', 'Merci de nous avoir contacté. Notre équipe va vous répondre dans les meilleurs délais');
            // redirige l'utilisateur vers la route 'app_account'
            return $this->redirectToRoute('app_account');
        }
        // rend le template 'contact/index.html.twig' en passant le formulaire à afficher
        return $this->render('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
}
