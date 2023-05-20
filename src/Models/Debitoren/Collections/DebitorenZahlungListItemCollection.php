<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungListItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungListItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenZahlungListItem;
use Illuminate\Support\Collection;

class DebitorenZahlungListItemCollection extends Collection
{
    public static function fromResponse(array $listItems): self
    {
        $items = array_map(static fn($item) =>
            DebitorenZahlungListItem::fromResponse($item),
            $listItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?DebitorenZahlungListItem
    {
        return parent::offsetGet($key);
    }
}
