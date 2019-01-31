<?php

namespace App\Tests\Unitaires;

use App\Entity\Reservation;
use App\Events\FullCalendarListener;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Toiba\FullCalendarBundle\Entity\Event;
use Toiba\FullCalendarBundle\Event\CalendarEvent;

class FullCalendarListenerTest extends KernelTestCase
{
    /**
     * @var FullCalendarListener
     */
    private $fullCalendarListener;

    public function setUp()
    {
        self::bootKernel($options = []);

        $entityManagerMock = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
            ;
        $urlGeneratorMock = $this->getMockBuilder(UrlGeneratorInterface::class)
            ->disableOriginalConstructor()
            ->getMock()
            ;

        $this->fullCalendarListener = new FullCalendarListener($entityManagerMock, $urlGeneratorMock);

        $this->assertInstanceOf(FullCalendarListener::class, $this->fullCalendarListener);
    }

    public function test_if_too_few_arguments_on_constructor()
    {
        $errorFewArguments = $this->expectException(\ArgumentCountError::class);

        new FullCalendarListener();
    }

    /**
     * @throws \Exception
     */
    public function test_full_calendar_load_events(): void
    {
        $reservations = $this->getMockBuilder(FullCalendarListener::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['loadEvents'])
                        ->getMock()
                        ;

        $start = new \DateTime('2019-01-29 09:15:00', new \DateTimeZone('Europe/Paris'));

        $end = new \DateTime('2019-01-31 12:15:00', new \DateTimeZone('Europe/Paris'));

        $calendar = new CalendarEvent($start, $end, $filter = []);

        /* @var Reservation $reservations */
        $this->assertInstanceOf(CalendarEvent::class, $reservations->loadEvents($calendar));
    }

    public function test_load_events_contains_events()
    {
        $container = self::$container;

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $urlGenerator = $container->get('router')->getGenerator();

        $this->assertInstanceOf(Container::class, $container);

        $oneReservation = $entityManager->getRepository(Reservation::class)->findOneBy(['id' => 9]);

        $title = $oneReservation->getTitle();

        $start = $oneReservation->getDateDebut();

        $end = $oneReservation->getDateFin();

        $loadEvents = new FullCalendarListener($entityManager, $urlGenerator);

        $calendar = new CalendarEvent($start, $end, $filter = []);

        $this->assertInstanceOf(Event::class, new Event($title, $start, $end));

        $url = $urlGenerator->generate('booking.reservation.show', ['id' => $oneReservation->getId()]);

        $this->assertEquals('/reservation/show/9', $url);
    }

    public function test_load_events_load_reservations_entity()
    {
        $calendar = new CalendarEvent(new \Datetime('2019-01-01'), new \DateTime('2019-04-01'), $filter = []);

        $this->assertEquals(new \DateTime('2019-01-01'), $calendar->getStart());

        $this->assertEquals(new \DateTime('2019-04-01'), $calendar->getEnd());

        $container = self::$container;

        $entityManager = $container->get('doctrine.orm.entity_manager');

        $repository = $entityManager->getRepository(Reservation::class);

        $reservations = $repository->findAllReservationsByStatus($calendar->getStart(), $calendar->getEnd(), 'accepted');

        $this->assertContainsOnlyInstancesOf(Reservation::class, $reservations);

    }
}
