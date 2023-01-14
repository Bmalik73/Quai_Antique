<?php

namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        // Stocker le gestionnaire d'entités dans une variable privée
        $this->entityManager = $entityManager;
    }

    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Récupère les menus qui ont le statut de meilleur (isBest = 1) depuis la base de données
        $menus = $this->entityManager->getRepository(Menu::class)->findByisBest(1);

        // Rend la vue 'home/index.html.twig' en passant les menus récupérés
        return $this->render('home/index.html.twig',[
            'menus' => $menus
        ]);
    }
}
