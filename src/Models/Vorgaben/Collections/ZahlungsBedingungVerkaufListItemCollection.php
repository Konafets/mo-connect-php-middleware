<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\ZahlungsBedingungVerkaufListItem;
use Iterator;

class ZahlungsBedingungVerkaufListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $zahlungsBedingungVerkaufListItems): self
    {
        $items = array_map(static fn($item) =>
            ZahlungsBedingungVerkaufListItem::fromResponse($item),
            $zahlungsBedingungVerkaufListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?ZahlungsBedingungVerkaufListItem
    {
        return parent::offsetGet($offset);
    }
}
