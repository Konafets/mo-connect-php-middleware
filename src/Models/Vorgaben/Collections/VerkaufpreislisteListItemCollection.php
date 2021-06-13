<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\VerkaufpreislisteListItem;
use Iterator;

class VerkaufpreislisteListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $verkaufpreislisteListItems): self
    {
        $items = array_map(static fn($item) =>
            VerkaufpreislisteListItem::fromResponse($item),
            $verkaufpreislisteListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?VerkaufpreislisteListItem
    {
        return parent::offsetGet($offset);
    }
}
