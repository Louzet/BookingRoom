<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="booking.home")
     * @Route("/", name="booking")
     */
    public function home()
    {
        return $this->render('booking/home.html.twig', [
        ]);
    }

    public function carousel()
    {
        return $this->render('components/_carousel.html.twig');
    }
}
