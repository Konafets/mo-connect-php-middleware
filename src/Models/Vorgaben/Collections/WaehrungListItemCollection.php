<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\WaehrungListItem;
use Iterator;

class WaehrungListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $waehrungListItems): self
    {
        $items = array_map(static fn($item) =>
            WaehrungListItem::fromResponse($item),
            $waehrungListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?WaehrungListItem
    {
        return parent::offsetGet($offset);
    }
}
