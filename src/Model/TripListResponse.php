<?php

namespace App\Model;

class TripListResponse
{
    /**
     * @var TripListItem[]
     */
    private array $items;

    /**
     * @param TripListItem[] $items
     */
    public function __construct(
        array $items,
        private ?array $pagination = null,
        private ?int $currentPage = null,
        private ?int $perPage = null,
        private ?int $total = null,)
    {
        $this->items = $items;
    }

    /**
     * @return TripListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function getPagination(): ?array
    {
        return $this->pagination;
    }

    public function getCurrentPage(): ?int
    {
        return $this->currentPage;
    }

    public function getPerPage(): ?int
    {
        return $this->perPage;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }
}
