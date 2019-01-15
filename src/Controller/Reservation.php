<?php
/**
 * Created by PhpStorm.
 * User: Nix
 * Date: 07/01/2019
 * Time: 13:18
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class Reservation extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/reservation", name="booking.reservation.index")
     */
    public function reservationIndex()
    {
        return $this->render("booking/reservation.html.twig");
    }
}