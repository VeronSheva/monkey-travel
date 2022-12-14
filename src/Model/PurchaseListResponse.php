<?php

namespace App\Model;

class PurchaseListResponse
{
    /**
     * @var PurchaseOutListItem[]
     */
    private array $items;

    /**
     * @param PurchaseOutListItem[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return PurchaseOutListItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
