<?php

namespace App\Entity;

use App\Repository\TripRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TripRepository::class)]
class Trip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $price;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(length: 120)]
    private string $name;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $date_start;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private DateTimeInterface $date_end;

    #[ORM\Column]
    private int $duration;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice():  int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }


    public function getDateStart(): ?DateTimeInterface
    {
        return $this->date_start;
    }


    public function setDateStart(DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;
        return $this;
    }

    public function getDateEnd(): ?DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;
        return $this;
    }


    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }


}
