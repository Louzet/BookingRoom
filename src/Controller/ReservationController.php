<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use App\Traits\TransliteratorSlugTrait;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\Workflow\Registry;

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
    public function reservationCreate(Request $request, Registry $workflows): Response
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        $reservation = new Reservation();

        $workflow = $workflows->get($reservation);

        $form = $this->createForm(ReservationType::class, $reservation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReservedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            $reservation->setUser($this->getUser());

            $reservation->setTitle($this->slugify($this->getUser()->getLastName().'-'.$reservation->getSalle()->getSlug().'-'.$reservation->getReservedAt()->format('d-m-Y')));

            try {
                $workflow->apply($reservation, 'to_pending');

                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();   // Insertion en base de donnée
            } catch (LogicException $exception) {
                // Transition non autorisé
                // Notification
                $this->addFlash(
                    'notice',
                    'Transition workflow non autorisée !'
                );
            }

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
     * @param Request  $request
     * @param Room     $room
     * @param Registry $workflows
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @throws \Exception
     * @Route("/reservation/create/{slug}", name="booking.reservation.room")
     */
    public function reservationFromRoom(Request $request, Room $room, Registry $workflows)
    {
        if (null === $this->getUser()) {
            return $this->redirectToRoute('user.login');
        }

        $reservation = new Reservation();

        // on récupère le workflow
        $workflow = $workflows->get($reservation);

        $reservation->setSalle($room);

        $form = $this->createForm(ReservationType::class, $reservation)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservation->setReservedAt(new \DateTime('now', new \DateTimeZone('Europe/Paris')));

            $reservation->setUser($this->getUser());

            $reservation->setTitle($this->slugify($this->getUser()->getLastName().'-'.$reservation->getSalle()->getSlug().'-'.$reservation->getReservedAt()->format('d-m-Y')));

            try {
                $workflow->apply($reservation, 'to_pending');

                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();   // Insertion en base de donnée
            } catch (LogicException $exception) {
                // Transition non autorisé
                // Notification
                $this->addFlash(
                    'notice',
                    'Transition workflow non autorisée !'
                );
            }

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

    /**
     * @param Reservation $reservation
     * @param Registry    $registry
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/confirm-reservation/{title}", name="reservation.confirmed")
     */
    public function ConfirmReservation(Reservation $reservation, Registry $registry): RedirectResponse
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('user.login');
        }

        $workflow = $registry->get($reservation);

        try {
            $workflow->apply($reservation, 'to_accept');

            $this->manager->persist($reservation);
            $this->manager->flush();
        } catch (LogicException $exception) {
            // Transition non autorisé
            // Notification
            $this->addFlash(
                'notice',
                'Transition workflow non autorisée !'
            );
        }

        $this->addFlash('success', 'Confirmation prises en compte ! !');

        return $this->redirectToRoute('user.profil', [
            'username' => $user->getUsername(),
        ]);
    }

    /**
     * @param Reservation $reservation
     * @param Registry    $registry
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/deny-reservation/{title}", name="reservation.denied")
     */
    public function AbandonReservation(Reservation $reservation, Registry $registry): RedirectResponse
    {
        $user = $this->getUser();

        if (null === $user) {
            return $this->redirectToRoute('user.login');
        }

        $workflow = $registry->get($reservation);

        try {
            $workflow->apply($reservation, 'to_reject');

            $historique = new Historique();

            $historique->setClient($reservation->getUser()->getEmail());

            $historique->setReservation($reservation->getTitle());

            $this->manager->persist($historique);

            $this->manager->persist($reservation);
            $this->manager->flush();
        } catch (LogicException $exception) {
            // Transition non autorisé
            // Notification
            $this->addFlash(
                'notice',
                'Transition workflow non autorisée !'
            );
        }

        $this->addFlash('success', 'Réservation annulé ! !');

        return $this->redirectToRoute('user.profil', [
            'username' => $user->getUsername(),
        ]);
    }
}
