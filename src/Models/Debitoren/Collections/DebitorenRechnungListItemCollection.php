<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungListItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungListItem;
use Illuminate\Support\Collection;

class DebitorenRechnungListItemCollection extends Collection
{
    public static function fromResponse(array $listItems): self
    {
        $items = array_map(static fn($item) =>
            DebitorenRechnungListItem::fromResponse($item),
            $listItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?DebitorenRechnungListItem
    {
        return parent::offsetGet($key);
    }
}
