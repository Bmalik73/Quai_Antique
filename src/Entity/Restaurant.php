<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOpenNoon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeCloseNoon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeOpenEvening = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timeCloseEvening = null;

    #[ORM\Column(nullable: true)]
    private ?int $seatNoon = null;

    #[ORM\Column(nullable: true)]
    private ?int $seatEvening = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeOpenNoon(): ?\DateTimeInterface
    {
        return $this->timeOpenNoon;
    }

    public function setTimeOpenNoon(?\DateTimeInterface $timeOpenNoon): self
    {
        $this->timeOpenNoon = $timeOpenNoon;

        return $this;
    }

    public function getTimeCloseNoon(): ?\DateTimeInterface
    {
        return $this->timeCloseNoon;
    }

    public function setTimeCloseNoon(?\DateTimeInterface $timeCloseNoon): self
    {
        $this->timeCloseNoon = $timeCloseNoon;

        return $this;
    }

    public function getTimeOpenEvening(): ?\DateTimeInterface
    {
        return $this->timeOpenEvening;
    }

    public function setTimeOpenEvening(?\DateTimeInterface $timeOpenEvening): self
    {
        $this->timeOpenEvening = $timeOpenEvening;

        return $this;
    }

    public function getTimeCloseEvening(): ?\DateTimeInterface
    {
        return $this->timeCloseEvening;
    }

    public function setTimeCloseEvening(?\DateTimeInterface $timeCloseEvening): self
    {
        $this->timeCloseEvening = $timeCloseEvening;

        return $this;
    }

    public function getSeatNoon(): ?int
    {
        return $this->seatNoon;
    }

    public function setSeatNoon(?int $seatNoon): self
    {
        $this->seatNoon = $seatNoon;

        return $this;
    }

    public function getSeatEvening(): ?int
    {
        return $this->seatEvening;
    }

    public function setSeatEvening(?int $seatEvening): self
    {
        $this->seatEvening = $seatEvening;

        return $this;
    }
}
