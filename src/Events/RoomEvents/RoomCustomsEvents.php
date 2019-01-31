<?php
/**
 * Created by PhpStorm.
 * User: mickael
 * Date: 29/01/19
 * Time: 15:53.
 */

namespace App\Events\RoomEvents;

use App\Entity\Room;
use Symfony\Component\EventDispatcher\Event;

class RoomCustomsEvents extends Event
{
    public const CREATED_RESERVATION = 'onCreatedReservation';
    /**
     * @var Room
     */
    private $room;

    public function __construct(Room $room)
    {
        $this->room = $room;
    }

    /**
     * @return Room
     */
    public function getRoom(): Room
    {
        return $this->room;
    }


}
