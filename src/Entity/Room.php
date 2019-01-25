<?php

namespace App\Entity;

use App\Traits\TransliteratorSlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoomRepository")
 */
class Room
{
    use TransliteratorSlugTrait;

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
     * @ORM\Column(type="string", length=255)
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
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     */
    private $PostalCode;

    /**
     * @ORM\Column(type="boolean")
     */
    private $disponible = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeOfRoom", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="salle")
     */
    private $reservations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="room", orphanRemoval=true, cascade={"all"})
     */
    private $images;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\VillesFranceFree", inversedBy="rooms")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville;

    public function __construct()
    {
        try {
            $this->dateCreation = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
        } catch (\Exception $e) {
        }
        $this->reservations = new ArrayCollection();
        $this->images = new ArrayCollection();
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


    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode()
    {
        return $this->PostalCode;
    }

    public function setPostalCode($PostalCode)
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

    /**
     * @return string|null
     *
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     *
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setSalle($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): self
    {
        if ($this->reservations->contains($reservation)) {
            $this->reservations->removeElement($reservation);
            // set the owning side to null (unless already changed)
            if ($reservation->getSalle() === $this) {
                $reservation->setSalle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setRoom($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getRoom() === $this) {
                $image->setRoom(null);
            }
        }

        return $this;
    }

    public function getVille(): ?VillesFranceFree
    {
        return $this->ville;
    }

    public function setVille(?VillesFranceFree $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

}
