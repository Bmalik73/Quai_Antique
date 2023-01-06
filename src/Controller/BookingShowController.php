<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingShowController extends AbstractController
{
    #[Route('/mes-reservations', name: 'app_booking_show')]
    public function index(): Response
    {
        return $this->render('booking_show/index.html.twig');
    }
}
