<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class Reservation extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/reservation", name="booking.reservation.index")
     */
    public function reservationIndex(): Response
    {
        return $this->render('booking/reservation.html.twig');
    }
}
