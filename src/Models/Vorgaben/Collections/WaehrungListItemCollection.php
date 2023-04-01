<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\WaehrungListItem;
use Illuminate\Support\Collection;

class WaehrungListItemCollection extends Collection
{

    public static function fromResponse(array $waehrungListItems): self
    {
        $items = array_map(static fn($item) =>
            WaehrungListItem::fromResponse($item),
            $waehrungListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?WaehrungListItem
    {
        return parent::offsetGet($key);
    }
}
