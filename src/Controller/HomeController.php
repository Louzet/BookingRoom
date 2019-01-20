<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;

    /**
     * HomeController constructor.
     *
     * @param RoomRepository $roomRepository
     */
    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }

    /**
     * @Route("/home", name="booking.home")
     * @Route("/", name="booking")
     */
    public function home()
    {
        $availableRooms = $this->roomRepository->findAvailableRooms();

        dump($availableRooms);

        return $this->render('booking/home.html.twig', [
            'availableRooms' => $availableRooms,
        ]);
    }

    public function carousel()
    {
        return $this->render('components/_carousel.html.twig');
    }
}
