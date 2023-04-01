<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\KostenstelleListItem;
use Illuminate\Support\Collection;

class KostenstelleListItemCollection extends Collection
{
    public static function fromResponse(array $kostenstelleListItems): self
    {
        $items = array_map(static fn($item) =>
            KostenstelleListItem::fromResponse($item),
            $kostenstelleListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?KostenstelleListItem
    {
        return parent::offsetGet($key);
    }
}
