<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Menu;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MenuController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        // Stocker le gestionnaire d'entités dans une variable privée
        $this->entityManager = $entityManager;
    }

    #[Route('/menus', name: 'app_menu')]
    public function index(Request $request): Response
    {
        // Récupère tous les menus depuis la base de données
        $menus = $this->entityManager->getRepository(Menu::class)->findAll();

        // Crée une instance de la classe Search et un formulaire de recherche en utilisant la classe SearchType
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        // Gère la demande et vérifie si le formulaire de recherche a été soumis
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère les menus en utilisant les critères de recherche saisis par l'utilisateur
            $menus = $this->entityManager->getRepository(Menu::class)->findWithSearch($search);
        }

        // Rend la vue 'menu/index.html.twig' en passant les menus récupérés et le formulaire de recherche
        return $this->render('menu/index.html.twig',[
            'menus' => $menus,
            'form' => $form->createView()
        ]);
    }


    #[Route('/nos-menus/{slug}', name: 'app_menus')]
    public function show($slug): Response
    {
        // Récupère le menu correspondant au slug donné depuis la base de données
        $menu = $this->entityManager->getRepository(Menu::class)->findOneBySlug($slug);

        if (!$menu){
            // Si le menu n'est pas trouvé, redirige vers la page de tous les menus
            return $this->redirectToRoute('app_menu');
        }
        // Rend la vue 'menu/show.html.twig' en passant le menu récupéré
        return $this->render('menu/show.html.twig', [
            'menu' => $menu
        ]);
    }
}