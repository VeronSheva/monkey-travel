<?php

namespace App\Model;

use App\Const\CountryCode;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseInListItem
{
    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $trip;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [CountryCode::class, 'values'])]
    private string $country_code;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^[0-9]{10}$/'
    )]
    private string $phone_number;

    #[Assert\Email]
    private ?string $email;

    #[Assert\Length(
        min: 2,
        max: 50,
    )]
    private string $name;

    #[Assert\NotBlank]
    #[Assert\Positive]
    private int $people;

    public function getTrip(): string
    {
        return $this->trip;
    }

    public function setTrip(string $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getCountryCode(): string
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

    public function getPeople(): int
    {
        return $this->people;
    }

    public function setPeople(int $people): self
    {
        $this->people = $people;

        return $this;
    }
}
