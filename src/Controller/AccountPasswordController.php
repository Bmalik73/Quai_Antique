<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    /**
     * AccountPasswordController constructor.
     * @param $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        // Stocker le gestionnaire d'entités dans une variable privée
        $this->entityManager = $entityManager;
    }

    #[Route('/compte/modifier-mon-mot-de-passe', name: 'app_account_password')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        // Récupère l'utilisateur connecté
        $user = $this->getUser();
        // Crée un formulaire en utilisant la classe ChangePasswordType pour l'utilisateur connecté
        $form = $this->createForm(ChangePasswordType::class, $user);
        // Gère la demande et vérifie si le formulaire a été soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'ancien mot de passe saisi par l'utilisateur
            $old_pwd = $form->get('old_password')->getData();

            if ($hasher->isPasswordValid($user, $old_pwd)) {
                // Récupère le nouveau mot de passe saisi par l'utilisateur
                $new_pwd = $form->get('new_password')->getData();
                // Hash le nouveau mot de passe
                $password = $hasher->hashPassword($user, $new_pwd);

                // Met à jour le mot de passe de l'utilisateur dans la base de données
                $user->setPassword($password);
                $this->entityManager->flush();
                // Ajoute un message flash pour informer l'utilisateur que le mot de passe a été mis à jour avec succès
                $this->addFlash('success','Votre mot de passe a bien été mis à jour.');
                // Redirige l'utilisateur vers la route 'app_account'
                return $this->redirectToRoute('app_account');
            } else {
                // Ajoute un message flash pour informer l'utilisateur que l'ancien mot de passe saisi n'est pas correct
                $this->addFlash('danger','Votre mot de passe actuel n\'est pas le bon.');
            }
        }

        // Rend la vue 'account/password.html.twig' en passant le formulaire à afficher
        return $this->render('account/password.html.twig',[
            'form' => $form,
        ]);
    }
}

