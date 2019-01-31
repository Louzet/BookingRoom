<?php

namespace App\Events\RoomEvents;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class RoomSuscriber.
 */
class RoomSuscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            RoomCustomsEvents::CREATED_RESERVATION => 'onCreatedReservation',
        ];
    }

    /**
     * @param RoomCustomsEvents $events
     *
     * rend la salle reservé indisponible, pendant le temps de la réservation courant
     */
    public function onCreatedReservation(RoomCustomsEvents $events): void
    {
        $disponibilite = $events->getRoom()->setDisponible(false);

        $this->manager->persist($disponibilite);

    }
}
