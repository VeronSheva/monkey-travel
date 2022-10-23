<?php

namespace App\Model;

class TripListItem
{
    private int $id;

    private string $name;

    private string $description;

    private int $price;

    private int $duration;

    private string $date_start;

    private string $date_end;

    /**
     * TripListItem constructor.
     */
    public function __construct(int $id, string $name, string $description, int $price, int $duration, string $date_start, string $date_end)
    {
        $this->name = $name;
        $this->id = $id;
        $this->description = $description;
        $this->price = $price;
        $this->duration = $duration;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getDateStart(): string
    {
        return $this->date_start;
    }

    public function setDateStart(string $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): string
    {
        return $this->date_end;
    }

    public function setDateEnd(string $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }
}
