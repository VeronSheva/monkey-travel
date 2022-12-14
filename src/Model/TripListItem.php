<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class TripListItem
{
    private ?int $id = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 300,
    )]
    private string $description;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $price;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $duration;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[Assert\NotBlank]
    private string $date_start;

    /**
     * @var string A "Y-m-d H:i:s" formatted value
     */
    #[Assert\DateTime]
    #[Assert\NotBlank]
    private string $date_end;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

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
