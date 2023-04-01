<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\NummernkreisListItem;
use Illuminate\Support\Collection;

class NummernkreisListItemCollection extends Collection
{
    public static function fromResponse(array $nummernkreisListItems): self
    {
        $items = array_map(static fn($item) =>
            NummernkreisListItem::fromResponse($item),
            $nummernkreisListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?NummernkreisListItem
    {
        return parent::offsetGet($key);
    }
}
