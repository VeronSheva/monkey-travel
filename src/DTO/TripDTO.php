<?php

namespace App\DTO;

class TripDTO
{
    private ?string $name;

    private ?string $description;

    private ?int $price;

    private ?int $duration;

    private ?string $destination;

    private ?string $date_start;

    private ?string $date_end;

    public function getDateStart(): ?string
    {
        return $this->date_start;
    }

    public function setDateStart(?string $date_start): void
    {
        $this->date_start = $date_start;
    }

    public function getDateEnd(): ?string
    {
        return $this->date_end;
    }

    public function setDateEnd(?string $date_end): void
    {
        $this->date_end = $date_end;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(?string $destination): void
    {
        $this->destination = $destination;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function setDuration(?int $duration): void
    {
        $this->duration = $duration;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): void
    {
        $this->price = $price;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }


}
