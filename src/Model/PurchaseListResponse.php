<?php

namespace App\Model;

class PurchaseListResponse
{
    /**
     * @var PurchaseListItem[]
     */
    private array $items;

    /**
     * @param PurchaseListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return PurchaseListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
