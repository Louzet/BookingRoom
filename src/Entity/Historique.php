<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoriqueRepository")
 */
class Historique
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reservation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $abandonDate;

    public function __construct()
    {
        try {
            $this->abandonDate = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        } catch (\Exception $e) {
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @param mixed $client
     */
    public function setClient($client): void
    {
        $this->client = $client;
    }

    public function getReservation(): ?string
    {
        return $this->reservation;
    }

    public function setReservation(string $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getAbandonDate(): ?\DateTimeInterface
    {
        return $this->abandonDate;
    }

    public function setAbandonDate(\DateTimeInterface $abandonDate): self
    {
        $this->abandonDate = $abandonDate;

        return $this;
    }
}
