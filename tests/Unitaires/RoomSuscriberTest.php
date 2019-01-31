<?php

namespace App\Tests\Unitaires;

use App\Entity\Room;
use App\Events\RoomEvents\RoomCustomsEvents;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class RoomSuscriberTest extends TestCase
{
    private $manager;

    public function setUp()
    {
        $this->manager = $this->getMockBuilder(EntityManagerInterface::class);
    }

    public function test_on_created_reservation()
    {
        $room = new Room();

        $events = new RoomCustomsEvents($room);

        $events->getRoom()->setDisponible(false);

        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();

        $objectManager->persist($events);

        $this->assertEquals(false, $events->getRoom()->getDisponible());
    }

    public function test_on_created_reservation_room_became_indisponible()
    {
        $room = new Room();

        $events = new RoomCustomsEvents($room);

        $events->getRoom()->setDisponible(false);

        $objectManager = $this->getMockBuilder(ObjectManager::class)
            ->getMock();

        $objectManager->persist($events);

        $this->assertFalse($events->getRoom()->getDisponible());
    }

    public function test_on_created_reservation_return()
    {
        $room = new Room();

        $events = new RoomCustomsEvents($room);

        $this->assertFalse($events->getRoom()->getDisponible());
    }
}
