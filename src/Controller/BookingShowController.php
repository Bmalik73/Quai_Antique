<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingShowController extends AbstractController
{
    // déclarez une variable privée pour le gestionnaire d'entités
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        // stocker le gestionnaire d'entités dans la variable privée
        $this->entityManager = $entityManager;

    }

    #[Route('/mes-reservations', name: 'app_booking_show')]
    public function index(): Response
    {
        // récupère l'utilisateur actuellement connecté
        $user = $this->getUser();
        // récupère l'email de l'utilisateur
        $email = $user->getEmail();

        // utilise le gestionnaire d'entités pour créer une requête pour sélectionner les réservations où l'email correspond à l'email de l'utilisateur connecté
        $bookings = $this->entityManager->createQuery(
            'SELECT b
            FROM App:Booking b
            WHERE b.email = :email'
        )->setParameter('email', $email)
            ->getResult();

        // rend la vue et passe les réservations à afficher
        return $this->render('booking_show/index.html.twig', [
            'bookings' => $bookings
        ]);
    }
}

