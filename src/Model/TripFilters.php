<?php

namespace App\Model;

use App\Const\Countries;
use Doctrine\Common\Collections\Criteria;
use Symfony\Component\Validator\Constraints as Assert;

class TripFilters
{
    #[Assert\Type('array',
        message: 'Оберіть країну зі списку')]
    private array $countries = [];

    #[Assert\PositiveOrZero(
        message: 'Значення має бути не меншим за 0'
    )]
    private ?int $min_sum = null;

    #[Assert\Positive(
        message: 'Значення має бути більшим за 0'
    )]
    #[Assert\LessThanOrEqual(10000,
        message: 'Значення має бути не більшим за 10000'
    )]
    private ?int $max_sum = null;

    /**
     * @var string A "d-m-Y" formatted value
     */
    #[Assert\NotEqualTo('')]
    #[Assert\Date(
        message: 'Оберіть валідну дату'
    )]
    private ?string $date_start = null;

    /**
     * @var string A "d-m-Y" formatted value
     */
    #[Assert\NotEqualTo('')]
    #[Assert\Date(
        message: 'Оберіть валідну дату'
    )]
    private ?string $date_end = null;

    #[Assert\Type('string')]
    #[Assert\Choice(['price', 'date_start', 'id'],
        message: 'Оберіть критерій сортування зі списку'
    )]
    private ?string $sort_by = 'id';

    #[Assert\Type('string')]
    #[Assert\Choice([Criteria::ASC, Criteria::DESC],
        message: 'Оберіть порядок сортування зі списку'
    )]
    private ?string $sort_order = Criteria::DESC;

    #[Assert\Type('string')]
    #[Assert\Length(
        max: 50,
        maxMessage: 'Пошуковий запит має містити не більше 50 символів'
    )]
    private ?string $search_query = null;

    public function getCountries(): array
    {
        return $this->countries;
    }

    public function setCountries(?array $countries): self
    {
        $this->countries = $countries;

        return $this;
    }

    public function getMinSum(): ?int
    {
        return $this->min_sum;
    }

    public function setMinSum(?int $min_sum): self
    {
        $this->min_sum = $min_sum;

        return $this;
    }

    public function getMaxSum(): ?int
    {
        return $this->max_sum;
    }

    public function setMaxSum(?int $max_sum): self
    {
        $this->max_sum = $max_sum;

        return $this;
    }

    public function getDateStart(): ?string
    {
        return $this->date_start;
    }

    public function setDateStart(?string $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?string
    {
        return $this->date_end;
    }

    public function setDateEnd(?string $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getSortBy(): ?string
    {
        return $this->sort_by;
    }

    public function setSortBy(?string $sort_by): self
    {
        $this->sort_by = $sort_by;

        return $this;
    }

    public function getSortOrder(): ?string
    {
        return $this->sort_order;
    }

    public function setSortOrder(?string $sort_order): self
    {
        $this->sort_order = $sort_order;

        return $this;
    }

    public function getSearchQuery(): ?string
    {
        return $this->search_query;
    }

    public function setSearchQuery(?string $search_query): self
    {
        $this->search_query = $search_query;

        return $this;
    }

    #[Assert\IsTrue]
    public function IsCountriesValid(): bool
    {
        $countries = $this->countries;

        if (null === $countries) {
            return true;
        }

        foreach ($this->getCountries() as $country) {
            if (!Countries::label($country)) {
                return false;
            }
        }

        return true;
    }
}
