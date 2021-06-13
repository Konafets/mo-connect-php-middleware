<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\NummernkreisListItem;
use Iterator;

class NummernkreisListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $nummernkreisListItems): self
    {
        $items = array_map(static fn($item) =>
            NummernkreisListItem::fromResponse($item),
            $nummernkreisListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?NummernkreisListItem
    {
        return parent::offsetGet($offset);
    }
}
