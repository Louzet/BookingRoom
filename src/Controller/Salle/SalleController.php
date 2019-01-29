<?php

namespace App\Controller\Salle;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/salle")
 */
class SalleController extends AbstractController
{
    /**
     * @Route("/list", name="salles.list")
     */
    public function salleIndex()
    {
    }

    /**
     * @param Request $request
     * @param Room    $room
     * @Route("/show/{slug}", name="salles.show")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function salleShow(Request $request, Room $room)
    {
        return $this->render('salles/salle_show.html.twig', [
            'room' => $room,
        ]);
    }
}
