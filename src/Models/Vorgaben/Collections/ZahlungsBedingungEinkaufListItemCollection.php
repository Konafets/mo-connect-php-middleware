<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\ZahlungsBedingungEinkaufListItem;
use Illuminate\Support\Collection;

class ZahlungsBedingungEinkaufListItemCollection extends Collection
{
    public static function fromResponse(array $zahlungsBedingungEinkaufListItems): self
    {
        $items = array_map(static fn($item) =>
            ZahlungsBedingungEinkaufListItem::fromResponse($item),
            $zahlungsBedingungEinkaufListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?ZahlungsBedingungEinkaufListItem
    {
        return parent::offsetGet($key);
    }
}
