<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Traits\TransliteratorSlugTrait;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    use TransliteratorSlugTrait;

    /**
     * @var ObjectManager
     */
    private $manager;
    /**
     * @var ReservationRepository
     */
    private $reservationRepository;
    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(ObjectManager $manager, ReservationRepository $reservationRepository, EventDispatcherInterface $dispatcher)
    {
        $this->manager = $manager;
        $this->reservationRepository = $reservationRepository;
        $this->dispatcher = $dispatcher;
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

        $this->dispatcher->dispatch('fullcalendar.set_data::loadEvents');

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

            $reservation->setTitle($this->slugify($this->getUser()->getLastName().'-'.$reservation->getSalle()->getSlug().'-'.$reservation->getReservedAt()->format('d-m-Y')));

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
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @throws \Exception
     * @Route("/reservation/create/{slug}", name="booking.reservation.room")
     */
    public function reservationFromRoom(Request $request, Room $room)
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        $reservation = new Reservation();

        $reservation->setSalle($room);

        $form = $this->createForm(ReservationType::class, $reservation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReservedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            $reservation->setUser($this->getUser());

            $reservation->setTitle($this->slugify($this->getUser()->getLastName().'-'.$reservation->getSalle()->getSlug().'-'.$reservation->getReservedAt()->format('d-m-Y')));

            $this->manager->persist($reservation);

            $this->manager->flush();

            $this->addFlash('success', 'Votre réservation a été validé !');

            return $this->redirectToRoute('booking.reservation.show', [
                'id' => $reservation->getId(),
            ]);
        }

        return $this->render('booking/create_reservation.html.twig', [
            'form' => $form->createView(),
            'room' => $room,
        ]);
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
