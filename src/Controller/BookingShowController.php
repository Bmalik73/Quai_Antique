<?php

namespace App\Controller;

use App\Entity\Booking;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingShowController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;

    }

    #[Route('/mes-reservations', name: 'app_booking_show')]
    public function index(): Response
    {
        $user = $this->getUser();
        $email = $user->getEmail();

        $bookings = $this->entityManager->createQuery(
            'SELECT b
            FROM App:Booking b
            WHERE b.email = :email'
        )->setParameter('email', $email)
            ->getResult();

        return $this->render('booking_show/index.html.twig', [
            'bookings' => $bookings
        ]);
    }
}

