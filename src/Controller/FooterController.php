<?php

namespace App\Controller;

use App\Entity\Restaurant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{

    #[Route('/footer', name: 'app_footer')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        // Récupération du restaurant à afficher
        $restaurant = $entityManager
            ->getRepository(Restaurant::class)
            ->find(1);
        return $this->render('footer/index.html.twig', [
            'timeOpenNoon' => $restaurant->getTimeOpenNoon(),
            'timeCloseNoon' => $restaurant->getTimeCloseNoon(),
            'timeOpenEvening' => $restaurant->getTimeOpenEvening(),
            'timeCloseEvening' => $restaurant->getTimeCloseEvening(),
        ]);
    }

}
