<?php declare(strict_types=1);

namespace ArrobaIt\MoConnectApi\Models\Adressen\Collections;

use ArrobaIt\MoConnectApi\Models\Adressen\AdresseListItem;
use Illuminate\Support\Collection;

class AdresseListItemCollection extends Collection
{
    public static function fromResponse(array $adresseListItems): self
    {
        $items = array_map(static fn($item) =>
            AdresseListItem::fromResponse($item),
            $adresseListItems
        );

        return new self($items);
    }

    public function offsetGet($key): ?AdresseListItem
    {
        return parent::offsetGet($key);
    }
}
