<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Buchungen\Collections;

use ArrobaIt\MoConnectApi\Models\Buchungen\BuchungJournalItem;
use Illuminate\Support\Collection;
use stdClass;

class BuchungJournalItemListCollection extends Collection
{
    public static function fromResponse(stdClass $listItems): self
    {
        $items = array_map(static fn($item) =>
            BuchungJournalItem::fromResponse($item),
            $listItems->BuchungJournalItem
        );

        return new self($items);
    }

    public function offsetGet($key): ?BuchungJournalItem
    {
        return parent::offsetGet($key);
    }
}
