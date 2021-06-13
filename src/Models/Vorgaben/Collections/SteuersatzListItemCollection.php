<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\SteuersatzListItem;
use Iterator;

class SteuersatzListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $steuersatzListItems): self
    {
        $items = array_map(static fn($item) =>
            SteuersatzListItem::fromResponse($item),
            $steuersatzListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?SteuersatzListItem
    {
        return parent::offsetGet($offset);
    }
}
