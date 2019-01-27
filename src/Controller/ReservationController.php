<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ReservationRepository
     */
    private $reservationRepository;

    public function __construct(ObjectManager $manager, ReservationRepository $reservationRepository)
    {
        $this->manager = $manager;
        $this->reservationRepository = $reservationRepository;
    }

    /**
     * @Route("/reservation/calendar", name="booking.calendar")
     */
    public function calendar()
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        $reservations = $this->reservationRepository->findAll();

        dump($reservations);

        return $this->render('booking/calendar.html.twig');
    }

    /**
     * @Route("/reservation/create", name="booking.reservation.create")
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function reservationCreate(Request $request): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        $reservation = new Reservation();

        $form = $this->createForm(ReservationType::class, $reservation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReservedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            $reservation->setUser($this->getUser());

            $this->manager->persist($reservation);

            $this->manager->flush();

            $this->addFlash('success', 'Réservation bien prise en compte !');

            return $this->redirectToRoute('booking.reservation.show', [
                'id' => $reservation->getId(),
            ]);
        }

        return $this->render('booking/create_reservation.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Request $request
     * @param Room    $room
     * @Route("/reservation/create/{id}", name="booking.reservation.room")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function reservationFromRoom(Request $request, Room $room)
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/reservation/list", name="booking.reservation.index")
     */
    public function reservationIndex(): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        return $this->render('booking/reservation.html.twig');
    }

    /**
     * @param Request     $request
     * @param Reservation $reservation
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/reservation/show/{id}", name="booking.reservation.show")
     */
    public function reservationShow(Request $request, Reservation $reservation, $id): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        if (null === $reservation) {
            return $this->redirectToRoute('booking.home', [], Response::HTTP_MOVED_PERMANENTLY);
        }


        return $this->render('booking/reservation_show.html.twig', [
            'reservation' => $reservation,
        ]);
    }
}
