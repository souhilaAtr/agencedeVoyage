<?php

namespace App\Entity;

use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DestinationRepository::class)]
class Destination
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDestination = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $coutMoyen = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dureeVoyage = null;

    #[ORM\OneToMany(mappedBy: 'destination', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDestination(): ?string
    {
        return $this->nomDestination;
    }

    public function setNomDestination(string $nomDestination): static
    {
        $this->nomDestination = $nomDestination;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCoutMoyen(): ?float
    {
        return $this->coutMoyen;
    }

    public function setCoutMoyen(?float $coutMoyen): static
    {
        $this->coutMoyen = $coutMoyen;

        return $this;
    }

    public function getDureeVoyage(): ?\DateTimeInterface
    {
        return $this->dureeVoyage;
    }

    public function setDureeVoyage(?\DateTimeInterface $dureeVoyage): static
    {
        $this->dureeVoyage = $dureeVoyage;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setDestination($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getDestination() === $this) {
                $reservation->setDestination(null);
            }
        }

        return $this;
    }
}
