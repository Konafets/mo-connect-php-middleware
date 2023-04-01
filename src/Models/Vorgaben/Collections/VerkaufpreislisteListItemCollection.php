<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\VerkaufpreislisteListItem;
use Illuminate\Support\Collection;

class VerkaufpreislisteListItemCollection extends Collection
{
    public static function fromResponse(array $verkaufpreislisteListItems): self
    {
        $items = array_map(static fn($item) =>
            VerkaufpreislisteListItem::fromResponse($item),
            $verkaufpreislisteListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?VerkaufpreislisteListItem
    {
        return parent::offsetGet($key);
    }
}
