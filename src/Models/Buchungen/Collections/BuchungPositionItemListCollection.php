<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungPositionAddItem;
use Illuminate\Support\Collection;
use stdClass;

class BuchungPositionItemListCollection extends Collection
{

    public static function fromResponse(stdClass $listItems): self
    {
        $items = array_map(static fn($item) => BuchungPositionAddItem::fromResponse($item), $listItems->BuchungPositionAddItem);

        return new self($items);
    }

    public function offsetGet($key): ?BuchungPositionAddItem
    {
        return parent::offsetGet($key);
    }
}
