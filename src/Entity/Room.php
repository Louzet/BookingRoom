<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    /**
     *
     */
    private $slug;

    /**
     * @ORM\Column(type="float")
     */
    private $priceLocation;

    /**
     * @ORM\Column(type="integer")
     */
    private $PlaceCapacity;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $PostalCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible = true;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOfRoom", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var \DateTime $dateCreation
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    public function __construct()
    {
        $this->disponible = false;

        $this->dateCreation = new \DateTime("now", new \DateTimeZone("Europe/Paris"));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPriceLocation(): ?float
    {
        return $this->priceLocation;
    }

    public function setPriceLocation(float $priceLocation): self
    {
        $this->priceLocation = $priceLocation;

        return $this;
    }

    public function getPlaceCapacity(): ?int
    {
        return $this->PlaceCapacity;
    }

    public function setPlaceCapacity(int $PlaceCapacity): self
    {
        $this->PlaceCapacity = $PlaceCapacity;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?int
    {
        return $this->PostalCode;
    }

    public function setPostalCode(int $PostalCode): self
    {
        $this->PostalCode = $PostalCode;

        return $this;
    }

    public function getDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    public function getType(): ?TypeOfRoom
    {
        return $this->type;
    }

    public function setType(?TypeOfRoom $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation(): \DateTime
    {
        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     */
    public function setDateCreation(\DateTime $dateCreation): void
    {
        $this->dateCreation = $dateCreation;
    }

}
