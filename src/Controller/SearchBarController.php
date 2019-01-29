<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\MiniSearchBarType;
use App\Repository\RoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchBarController extends AbstractController
{
    /**
     * @param Request        $request
     * @param RoomRepository $roomRepository
     *
     * @Route("/result-query", name="search.query")
     *
     * @return Response
     */
    public function search(Request $request, RoomRepository $roomRepository): Response
    {
        $newSearch = new Search();

        $form = $this->createForm(MiniSearchBarType::class, $newSearch)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $rooms = $roomRepository->findRoomsByParams($newSearch);

            dump($rooms);

            return $this->render('booking/result-query.html.twig', [
                'rooms' => $rooms,
            ]);
        }

        return $this->render('booking/search.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
