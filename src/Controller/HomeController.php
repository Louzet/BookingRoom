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

        $villes = fopen(dirname(__DIR__, 2).'/public/villes_france.csv', 'r+');
        dump($villes);

        $row = 1;
        if (false !== ($handle = fopen(dirname(__DIR__, 2).'/public/villes_france.csv', 'r+'))) {
            while (false !== ($data = fgetcsv($handle, 1000))) {
                $num = count($data);
                dd($data);
                die();
                echo "<p> $num champs à la ligne $row: <br /></p>\n";
                ++$row;
                for ($c = 0; $c < $num; ++$c) {
                    echo $data[$c]."<br />\n";
                }
            }
            fclose($handle);
        }

        return $this->render('booking/home.html.twig', [
            'availableRooms' => $availableRooms,
        ]);
    }

    public function carousel()
    {
        return $this->render('components/_carousel.html.twig');
    }
}
