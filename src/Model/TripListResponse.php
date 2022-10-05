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
    public function __construct(array $items)
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


}
