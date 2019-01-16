<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Room",
     *     inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull(message="Vous devez choisir une room")
     */
    private $room;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User",
     *     inversedBy="reservations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="datetime", nullable=false)
     */
    private $dateFin;


/****************************************************************
*                      Constructeur                             *
****************************************************************/

    public function __construct()
    {
        $this->dateDebut = new \DateTime();
        $this->dateFin = new \DateTime();
    }


/****************************************************************
*                      Getters et Setter                        *
****************************************************************/

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getRoom()
    {
        return $this->room;
    }

    /**
     * @param mixed $room
     * @return Reservation
     */
    public function setIdRoom($room): self
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }


    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * Vérifie l'appartenance d'une réservation à un utilisateur
     * @param User|null $user
     * @return bool
     */
    public function belongToUser(?User $user = null): bool
    {
        return $user && $this->getUser()->getId() === $user->getId();
    }

}