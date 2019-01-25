<?php

namespace App\Entity;

/**
 * Class Search_.
 */
class Search
{
    /**
     * @var TypeOfRoom
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
     * @var VillesFranceFree
     */
    private $place;

    /**
     * @return TypeOfRoom|null
     */
    public function getEvenement(): ?TypeOfRoom
    {
        return $this->evenement;
    }

    /**
     * @param TypeOfRoom|null $evenement
     * @return void
     */
    public function setEvenement(?TypeOfRoom $evenement)
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
     * @return VillesFranceFree|null
     */
    public function getPlace(): ?VillesFranceFree
    {
        return $this->place;
    }

    /**
     * @param VillesFranceFree|null $place
     */
    public function setPlace(?VillesFranceFree $place): void
    {
        $this->place = $place;
    }
}
