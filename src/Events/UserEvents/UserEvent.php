<?php

namespace App\Events\UserEvents;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class UserEvent.
 */
class UserEvent extends Event
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserEvent constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return UserEvent
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
    }
}
