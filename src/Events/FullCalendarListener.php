<?php

namespace App\Events;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListener
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UrlGeneratorInterface
     */
    private $router;

    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public function loadEvents(CalendarEvent $calendar)
    {
        $startDate = $calendar->getStart();
        $endDate = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $reservations = $this->em->getRepository(Reservation::class)->findAllReservations($startDate, $endDate);

        foreach ($reservations as $reservation) {

            $reservation_event = new Event(
                $reservation->getTitle(),
                $reservation->getBeginAt(),
                $reservation->getEndAt()
            );

            $reservation_event->setUrl(
                $this->router->generate('booking.reservation.show', [
                    'id' => $reservation->getId(),

                ])
            );
            $calendar->addEvent($reservation_event);

        }

    }

}
