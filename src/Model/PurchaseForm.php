<?php

namespace App\Model;

use App\Const\CountryPhoneCode;
use Symfony\Component\Validator\Constraints as Assert;

class PurchaseForm
{
    #[Assert\NotNull]
    #[Assert\Positive]
    private int $trip;

    #[Assert\Sequentially(
        [
            new Assert\NotBlank(message: 'Оберіть код країни'),
            new Assert\Choice(callback: [CountryPhoneCode::class, 'names'],
                message: 'Вибрано неправильний код країни'),
        ]
    )]
    private ?string $country_code = null;

    #[Assert\Sequentially(
        [
            new Assert\NotBlank(message: 'Уведіть номер телефону'),
            new Assert\Regex(
                pattern: '/^[0-9]{9}$/',
                message: 'Уведено неправильний номер телефону')
        ]
    )]
    private ?string $phone_number = null;

    #[Assert\Email(message: 'Уведено неправильний e-mail')]
    private ?string $email = null;

    #[Assert\Sequentially(
        [
            new Assert\NotBlank(message: 'Уведіть ім\'я'),
            new Assert\Length(
                min: 2,
                max: 50,
                minMessage: 'Ім\'я має складатися мінімум з 2 символів',
                maxMessage: 'Ім\'я має складатися максимум з 50 символів')
        ]
    )]
    private ?string $name = null;

    #[Assert\Sequentially(
        [
            new Assert\NotBlank(message: 'Уведіть кількість людей'),
            new Assert\Positive(message: 'Кількість має бути більшою за 0')
        ]
    )]
    private ?int $people = null;

    public function getTrip(): string
    {
        return $this->trip;
    }

    public function setTrip(string $trip): self
    {
        $this->trip = $trip;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(?string $country_code): self
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phone_number;
    }

    public function setPhoneNumber(?string $phone_number): self
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPeople(): ?int
    {
        return $this->people;
    }

    public function setPeople(?int $people): self
    {
        $this->people = $people;

        return $this;
    }
}
