<?php

namespace App\Entity;

/**
 * Class Search_bar.
 */
class Search_bar
{
    /**
     * @var string|null
     */
    private $evenement;

    /**
     * @var \DateTime|null
     */
    private $date_debut;

    /**
     * @var \DateTime|null
     */
    private $date_fin;

    /**
     * @var string|null
     */
    private $place;

    /**
     * @return string|null
     */
    public function getEvenement(): ?string
    {
        return $this->evenement;
    }

    /**
     * @param string|null $evenement
     */
    public function setEvenement(?string $evenement): void
    {
        $this->evenement = $evenement;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateDebut(): ?\DateTime
    {
        return $this->date_debut;
    }

    /**
     * @param \DateTime|null $date_debut
     */
    public function setDateDebut(?\DateTime $date_debut): void
    {
        $this->date_debut = $date_debut;
    }

    /**
     * @return \DateTime|null
     */
    public function getDateFin(): ?\DateTime
    {
        return $this->date_fin;
    }

    /**
     * @param \DateTime|null $date_fin
     */
    public function setDateFin(?\DateTime $date_fin): void
    {
        $this->date_fin = $date_fin;
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string|null $place
     */
    public function setPlace(?string $place): void
    {
        $this->place = $place;
    }
}
