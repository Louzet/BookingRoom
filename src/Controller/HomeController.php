<?php

namespace App\Controller;

use App\Repository\RoomRepository;
use App\Repository\VillesFranceFreeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var RoomRepository
     */
    private $roomRepository;
    /**
     * @var VillesFranceFreeRepository
     */
    private $villeRepository;

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
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function home(Request $request)
    {
        $availableRooms = $this->roomRepository->findAvailableRooms();

        return $this->render('booking/home.html.twig', [
            'availableRooms' => $availableRooms,
        ]);
    }

    public function carousel()
    {
        return $this->render('components/_carousel.html.twig');
    }

    /**
     * @Route("/result-query", name="search.query")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function resultSearch()
    {
        $response = $this->forward('App\Controller\SearchBarController::search');

        dump($response);



        // ... further modify the response or return it directly

        return $this->render('booking/result-query.html.twig');
    }
}
