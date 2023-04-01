<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\ZahlungsBedingungVerkaufListItem;
use Illuminate\Support\Collection;

class ZahlungsBedingungVerkaufListItemCollection extends Collection
{
    public static function fromResponse(array $zahlungsBedingungVerkaufListItems): self
    {
        $items = array_map(static fn($item) =>
            ZahlungsBedingungVerkaufListItem::fromResponse($item),
            $zahlungsBedingungVerkaufListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?ZahlungsBedingungVerkaufListItem
    {
        return parent::offsetGet($key);
    }
}
