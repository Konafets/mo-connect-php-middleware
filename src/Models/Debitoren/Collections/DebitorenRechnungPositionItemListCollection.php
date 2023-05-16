<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Debitoren\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungPositionAddItem;
use ArrobaIt\MoConnectApi\Models\Debitoren\DebitorenRechnungPositionAddItem;
use Illuminate\Support\Collection;
use stdClass;

class DebitorenRechnungPositionItemListCollection extends Collection
{

    public static function fromResponse(stdClass $listItems): self
    {
        $items = array_map(static fn($item) => DebitorenRechnungPositionAddItem::fromResponse($item), $listItems->DebitorenRechnungPositionAddItem);

        return new self($items);
    }

    public function offsetGet($key): ?DebitorenRechnungPositionAddItem
    {
        return parent::offsetGet($key);
    }
}
