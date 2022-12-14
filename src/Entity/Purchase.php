<?php

namespace App\Entity;

use App\Repository\PurchaseRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PurchaseRepository::class)]
class Purchase
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private int $trip;

    #[ORM\Column(length: 10)]
    private string $country_code;

    #[ORM\Column(length: 50)]
    private string $phone_number;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    private string $name;

    #[ORM\Column]
    private \DateTimeImmutable $order_time;

    #[ORM\Column]
    private int $people;

    #[ORM\Column]
    private int $sum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTrip(): int
    {
        return $this->trip;
    }

    public function setTrip(int $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(string $phone_number): self
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    public function getOrderTime(): \DateTimeImmutable
    {
        return $this->order_time;
    }

    public function setOrderTime(\DateTimeImmutable $order_time): self
    {
        $this->order_time = $order_time;

        return $this;
    }

    public function getPeople(): int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;

        return $this;
    }

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): self
    {
        $this->sum = $sum;

        return $this;
    }
}
