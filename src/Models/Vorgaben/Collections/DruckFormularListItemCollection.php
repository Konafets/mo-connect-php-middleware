<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\DruckFormularListItem;
use Illuminate\Support\Collection;

class DruckFormularListItemCollection extends Collection
{
    public static function fromResponse(array $druckFormularListItems): self
    {
        $items = array_map(static fn($item) =>
            DruckFormularListItem::fromResponse($item),
            $druckFormularListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?DruckFormularListItem
    {
        return parent::offsetGet($key);
    }
}
