<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\SepaMandatListItem;
use Illuminate\Support\Collection;

class SepaMandatListItems extends Collection
{
    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            SepaMandatListItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?SepaMandatListItem
    {
        return parent::offsetGet($key);
    }
}
