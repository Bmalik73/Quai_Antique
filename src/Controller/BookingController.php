<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;

    }

    #[Route('/reservation', name: 'app_booking')]
    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        // Récupère l'objet utilisateur actuellement connecté
        $user = $this->getUser();
        // Récupère l'email de l'utilisateur
        $email = $user->getEmail();

        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet Booking contenant les données du formulaire
            $booking = $form->getData();
            // Enregistre l'email de l'utilisateur dans l'objet Booking
            $booking->setEmail($email);
            // Enregistre l'objet Booking en base de données
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre réservation a bien été envoyé');

        }

        return $this->render('booking/index.html.twig', [
            'form' => $form
        ]);

    }
}
