<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Entity\Restaurant;
use App\Form\BookingType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    #[Route('/reservation', name: 'app_booking')]
    /*public function index(Request $request): Response
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

        // Récupération du restaurant
        $restaurant = $this->entityManager
            ->getRepository(Restaurant::class)
            ->find(1);

        // Vérification du nombre de places disponibles
        if ($booking->getDay() === 'midi' && $restaurant->getSeatNoon() > 0) {
            // Décrémentation du nombre de places disponibles
            $restaurant->setSeatNoon($restaurant->getSeatNoon() - 1);
            // Enregistrement de la réservation en base de données
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre réservation a bien été enregistrée.');
            return $this->redirectToRoute('app_home');
        } elseif ($booking->getDay() === 'soir' && $restaurant->getSeatEvening() > 0) {
            // Décrémentation du nombre de places disponibles
            $restaurant->setSeatEvening($restaurant->getSeatEvening() - 1);
            // Enregistrement de la réservation en base de données
            $this->entityManager->persist($booking);
            $this->entityManager->flush();
            $this->addFlash('success', 'Votre réservation a bien été enregistrée.');
            return $this->redirectToRoute('app_home');
        } else {
            // Affichage d'un message d'erreur
            $this->addFlash('error', 'Le restaurant est complet pour ce service.');
        }
    }*/



    public function index(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        // Récupère l'objet utilisateur actuellement connecté
        $user = $this->getUser();
        // Récupère l'email de l'utilisateur
        $email = $user->getEmail();
        // Récupération du restaurant
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère l'objet Restaurant associé à la réservation
            $restaurant = $this->entityManager
                ->getRepository(Restaurant::class)
                ->find(1);

            // Récupère l'objet Booking contenant les données du formulaire
            $booking = $form->getData();
            // Ajout du restaurant à l'objet Booking
            $booking->setRelatedTo($restaurant);

            // Récupère le jour et l'heure de la réservation
                $day = $booking->getDay();
                $hour = $booking->getHour();

                if ($day === null || $hour === null) {
                    // Si le jour ou l'heure sont null, affiche un message d'erreur
                    $this->addFlash('danger', 'Jour ou heure de réservation non valides');
                } else {
                    // Récupère le nombre de places demandées
                    $seats = $booking->getSeats();

                    if ($seats <= 0) {
                        // Si le nombre de places est inférieur ou égal à zéro, affiche un message d'erreur
                        $this->addFlash('danger', 'Le nombre de places doit être supérieur à zéro');
                    } else {
                        // Récupère le nombre de places disponibles pour le jour et l'heure de la réservation
                        $availableSeats = $this->getAvailableSeats($day, $hour, $restaurant);

                        // Si le nombre de places demandées est disponible
                        if ($availableSeats >= $seats) {
                            // Enregistre l'email de l'utilisateur dans l'objet Booking
                            $booking->setEmail($email);
                            // Enregistre l'objet Booking en base de données
                            $this->entityManager->persist($booking);
                            $this->entityManager->flush();
                            $this->addFlash('success', 'Votre réservation a bien été envoyé');
                        } else {
                            $this->addFlash('danger', 'Il n\'y a pas assez de places disponibles pour votre réservation');
                        }
                    }
                }
            }

                return $this->render('booking/index.html.twig', [
                    'form' => $form
                ]);
    }




    private
    function getAvailableSeats(\DateTimeInterface $day, \DateTimeInterface $hour, Restaurant $restaurant): int
    {
        // Récupère les réservations pour le jour et l'heure donnés
        $bookings = $this->entityManager
            ->getRepository(Booking::class)
            ->findBy(['day' => $day, 'hour' => $hour, 'relatedTo' => $restaurant]);

        // Calcule le nombre de places prises en comptant toutes les réservations
        $takenSeats = array_reduce($bookings, function (int $total, Booking $booking) {
            return $total + $booking->getSeats();
        }, 0);

        // Renvoie le nombre de places disponibles en soustrayant le nombre de places prises au nombre total de places
        return $restaurant->getSeatNoon() - $takenSeats;


    }
}
