<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrayAccess;
use ArrobaIt\MoConnectApi\Models\Collection;
use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use ArrobaIt\MoConnectApi\Models\Vorgaben\ZahlungsBedingungEinkaufListItem;
use Iterator;

class ZahlungsBedingungEinkaufListItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public static function fromResponse(array $zahlungsBedingungEinkaufListItems): self
    {
        $items = array_map(static fn($item) =>
            ZahlungsBedingungEinkaufListItem::fromResponse($item),
            $zahlungsBedingungEinkaufListItems
        );

        return new self($items);
    }

    public function offsetGet($offset): ?ZahlungsBedingungEinkaufListItem
    {
        return parent::offsetGet($offset);
    }
}
