<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Vorgaben\Collections;

use ArrobaIt\MoConnectApi\Models\Vorgaben\SteuersatzListItem;
use Illuminate\Support\Collection;

class SteuersatzListItemCollection extends Collection
{
    public static function fromResponse(array $steuersatzListItems): self
    {
        $items = array_map(static fn($item) =>
            SteuersatzListItem::fromResponse($item),
            $steuersatzListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?SteuersatzListItem
    {
        return parent::offsetGet($key);
    }
}
