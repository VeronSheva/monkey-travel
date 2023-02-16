<?php

namespace App\Model;

class PurchaseOutListItem
{
    private int $id;

    private string $trip;

    private string $phone_number;

    private ?string $email;

    private string $name;

    private string $order_time;

    private int $people;

    private int $sum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTrip(): string
    {
        return $this->trip;
    }

    public function setTrip(string $trip): self
    {
        $this->trip = $trip;

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

    public function getOrderTime(): string
    {
        return $this->order_time;
    }

    public function setOrderTime(string $order_time): self
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
