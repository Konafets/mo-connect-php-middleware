<?php

declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungListItem;
use Illuminate\Support\Collection;

class BuchungenListItemCollection extends Collection
{
    public static function fromResponse(array $listItems): self
    {
        $items = array_map(static fn($item) =>
            BuchungListItem::fromResponse($item),
            $listItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?BuchungListItem
    {
        return parent::offsetGet($key);
    }
}
