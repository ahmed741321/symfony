<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $checkInDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $checkOutDate = null;

    #[ORM\OneToMany(targetEntity: guest::class, mappedBy: 'registration')]
    private Collection $guests;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    private ?user $user = null;

    public function __construct()
    {
        $this->guests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCheckInDate(): ?\DateTimeInterface
    {
        return $this->checkInDate;
    }

    public function setCheckInDate(\DateTimeInterface $checkInDate): static
    {
        $this->checkInDate = $checkInDate;

        return $this;
    }

    public function getCheckOutDate(): ?\DateTimeInterface
    {
        return $this->checkOutDate;
    }

    public function setCheckOutDate(\DateTimeInterface $checkOutDate): static
    {
        $this->checkOutDate = $checkOutDate;

        return $this;
    }

    /**
     * @return Collection<int, guest>
     */
    public function getGuests(): Collection
    {
        return $this->guests;
    }

    public function addGuest(guest $guest): static
    {
        if (!$this->guests->contains($guest)) {
            $this->guests->add($guest);
            $guest->setRegistration($this);
        }

        return $this;
    }

    public function removeGuest(guest $guest): static
    {
        if ($this->guests->removeElement($guest)) {
            // set the owning side to null (unless already changed)
            if ($guest->getRegistration() === $this) {
                $guest->setRegistration(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }
}
